<?php

namespace App\Http\Controllers;

use App\Exports\CollectionExporter;
use App\Http\Requests\SaveUploadRequest;
use App\Http\Requests\UploadFileRequest;
use App\Models\BookingType;
use App\Models\Customer;
use App\Models\DocumentType;
use App\Models\Upload;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class UploadController extends Controller
{
    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Upload::class);
    }

    /**
     * Display a listing of the document.
     *
     * @param Request $request
     * @param CollectionExporter $exporter
     * @return View|BinaryFileResponse|StreamedResponse
     */
    public function index(Request $request, CollectionExporter $exporter)
    {
        $uploads = Upload::withCount('uploadDocuments as document_total')
            ->q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        if ($request->get('export')) {
            return $exporter->streamDownload($uploads->cursor(), [
                'title' => 'Upload Data',
                'fileName' => 'Uploads.xlsx',
                'excludes' => ['id', 'deleted_at'],
            ]);
        } else {
            $uploads = $uploads->paginate();
            return view('uploads.index', compact('uploads'));
        }
    }

    /**
     * Show the form for creating a new document.
     *
     * @return View
     */
    public function create()
    {
        $customers = Customer::all();
        $bookingTypes = BookingType::all();
        $documentTypes = DocumentType::all();

        return view('uploads.create', compact('customers', 'bookingTypes', 'documentTypes'));
    }

    /**
     * Store a newly created document in storage.
     *
     * @param SaveUploadRequest $request
     * @return Response|RedirectResponse
     */
    public function store(SaveUploadRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $upload = Upload::create($request->input());

            foreach ($request->input('documents') as $document) {
                $document['document_date'] = Carbon::parse($document['document_date'])->format('Y-m-d');
                $uploadDocument = $upload->uploadDocuments()->create($document);

                $files = data_get($request->input('documents'), $uploadDocument->document_type_id . '.files', []);
                foreach ($files as $file) {
                    $uploadDocument->uploadDocumentFiles()->create($this->moveUploadedFile($file));
                }
            }

            return redirect()->route('uploads.index')->with([
                "status" => "success",
                "message" => "Upload document {$upload->upload_number} successfully created"
            ]);
        });
    }

    /**
     * Display the specified document.
     *
     * @param Upload $upload
     * @return View
     */
    public function show(Upload $upload)
    {
        return view('uploads.show', compact('upload'));
    }

    /**
     * Show the form for editing the specified document.
     *
     * @param Upload $upload
     * @return View
     */
    public function edit(Upload $upload)
    {
        $customers = Customer::all();
        $bookingTypes = BookingType::all();
        $documentTypes = DocumentType::all();

        return view('uploads.edit', compact('upload', 'customers', 'bookingTypes', 'documentTypes'));
    }

    /**
     * Update the specified document in storage.
     *
     * @param SaveUploadRequest $request
     * @param Upload $upload
     * @return Response|RedirectResponse
     */
    public function update(SaveUploadRequest $request, Upload $upload)
    {
        return DB::transaction(function () use ($request, $upload) {
            $upload->fill($request->input());
            $upload->save();

            foreach ($request->input('documents') as &$document) {
                $document['document_date'] = Carbon::parse($document['document_date'])->format('Y-m-d');
                $uploadDocument = $upload->uploadDocuments()->where('document_type_id', $document['document_type_id'])->first();
                if (empty($uploadDocument)) {
                    $uploadDocument = $upload->uploadDocuments()->create($document);
                } else {
                    $uploadDocument->fill($document);
                    $uploadDocument->save();
                }

                $uploadDocument->uploadDocumentFiles()->delete();
                $files = data_get($request->input('documents'), $uploadDocument->document_type_id . '.files', []);
                foreach ($files as $file) {
                    $newFile = [
                        'src' => $file['src'],
                        'file_name' => $file['file_name']
                    ];
                    if (empty($file['id'])) {
                        $newFile = $this->moveUploadedFile($file);
                    }
                    $uploadDocument->uploadDocumentFiles()->create($newFile);
                }
            }

            return redirect()->route('uploads.index')->with([
                "status" => "success",
                "message" => "Upload document {$upload->upload_number} successfully updated"
            ]);
        });
    }

    /**
     * Move uploaded temp file into proper folder and return destination src and file name.
     *
     * @param $file
     * @return array
     */
    private function moveUploadedFile($file)
    {
        $moveFileTo = 'documents/' . date('Y/m/') . basename($file['src']);
        if (Storage::exists($moveFileTo)) {
            Storage::delete($moveFileTo);
        }
        if (Storage::move($file['src'], $moveFileTo)) {
            $file['src'] = $moveFileTo;
            if (empty($file['file_name'])) {
                $file['file_name'] = basename($file['src']);
            }
        } else {
            abort(500, __('Move uploaded file failed'));
        }

        return [
            'src' => $file['src'],
            'file_name' => $file['file_name'],
        ];
    }

    /**
     * Remove the specified document from storage.
     *
     * @param Upload $upload
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Upload $upload)
    {
        $upload->delete();

        return redirect()->back()->with([
            "status" => "warning",
            "message" => "Upload {$upload->upload_number} successfully deleted"
        ]);
    }

    /**
     * Validate upload.
     *
     * @param Upload $upload
     * @return RedirectResponse
     */
    public function validateUpload(Upload $upload)
    {
        $upload->status = Upload::STATUS_VALIDATED;
        $upload->save();

        return redirect()->back()->with([
            "status" => "success",
            "message" => "Upload {$upload->upload_number} successfully validated and ready to booked"
        ]);
    }

    /**
     * Download documents.
     *
     * @param Upload $upload
     * @return BinaryFileResponse
     */
    public function download(Upload $upload)
    {
        $zipFile = storage_path("app/exports/temp/{$upload->upload_number}.zip");

        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($upload->uploadDocuments as $uploadDocument) {
            foreach ($uploadDocument->uploadDocumentFiles as $file) {
                $localName = $uploadDocument->documentType->document_name . '/' . ($file->file_name ?: basename($file->src));
                $zip->addFile(storage_path('app/' . $file->src), $localName);
            }
        }

        $zip->close();

        return response()->download($zipFile)->deleteFileAfterSend(true);
    }

    /**
     * Upload file into temporary.
     *
     * @param UploadFileRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function upload(UploadFileRequest $request)
    {
        $file = $request->file('file');
        $path = $file->store('temp');
        if ($path === false) {
            $messages = [
                'status' => 'failed',
                'message' => __('Upload file failed, try again later')
            ];
            if ($request->acceptsJson()) {
                return response()->json($messages);
            } else {
                return redirect()->back()->with($messages);
            }
        }

        $originalName = $file->getClientOriginalName();
        $extension = $file->extension();

        if ($request->acceptsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'path' => $path,
                    'uploaded_name' => basename($path),
                    'original_name' => $originalName,
                    'extension' => $extension,
                ]
            ]);
        } else {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => __('File successfully uploaded')
            ]);
        }
    }
}
