<?php

namespace App\Http\Controllers;

use App\Exports\CollectionExporter;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $upload = Upload::create($request->input());

            foreach ($request->input('documents') as &$document) {
                $document['document_date'] = Carbon::parse($document['document_date'])->format('Y-m-d');
                $uploadDocument = $upload->uploadDocuments()->create($document);

                $files = data_get($request->input('documents'), $uploadDocument->document_type_id . '.files', []);
                foreach ($files as $file) {
                    $moveFileTo = 'documents/' . date('Y/m/') . basename($file['src']);
                    if (Storage::exists($moveFileTo)) {
                        Storage::delete($moveFileTo);
                    }
                    if (Storage::copy($file['src'], $moveFileTo)) {
                        $file['src'] = $moveFileTo;
                        if (empty($file['file_name'])) {
                            $file['file_name'] = basename($file['src']);
                        }
                        $uploadDocument->uploadDocumentFiles()->create([
                            'src' => $file['src'],
                            'file_name' => $file['file_name'],
                        ]);
                    } else {
                        abort(500, 'Move uploaded file failed');
                    }
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
     * @return \Illuminate\Http\Response
     */
    public function edit(Upload $upload)
    {
        //
    }

    /**
     * Update the specified document in storage.
     *
     * @param Request $request
     * @param Upload $upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Upload $upload)
    {
        //
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
     * Upload file into temporary.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     * @throws ValidationException
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => ['required', 'file', 'max:2000', 'mimes:jpeg,jpg,bmp,png,gif,pdf,zip,rar,doc,docx,ppt,txt,xls,xlsx'],
        ]);

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
                'message' => 'File successfully uploaded'
            ]);
        }
    }
}
