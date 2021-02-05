<?php

namespace App\Http\Controllers\Api;

use App\Events\UploadValidatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveUploadRequest;
use App\Http\Requests\SaveUserRequest;
use App\Http\Requests\UploadFileRequest;
use App\Models\Upload;
use App\Models\UploadDocumentFile;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class UploadController extends Controller
{
    /**
     * UploadController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Upload::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $uploads = Upload::with(['booking', 'customer', 'bookingType'])->withCount('uploadDocuments as document_total')
            ->q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'))
            ->paginate();

        return response()->json($uploads);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaveUploadRequest $request
     * @return JsonResponse
     */
    public function store(SaveUploadRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $upload = Upload::create($request->validated());

            foreach ($request->input('documents') as $document) {
                $document['document_date'] = Carbon::parse($document['document_date'])->format('Y-m-d');
                $uploadDocument = $upload->uploadDocuments()->create($document);

                $files = data_get($document, 'files', []);
                foreach ($files as $file) {
                    $uploadDocument->uploadDocumentFiles()->create($upload->moveUploadedFile($file));
                }
            }

            $upload->statusHistories()->create([
                'status' => Upload::STATUS_DRAFT,
                'description' => 'Initial upload'
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $upload->load('uploadDocuments'),
                'message' => __("Upload document :number successfully created", [
                    'number' => $upload->upload_number
                ])
            ]);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param Upload $upload
     * @return JsonResponse
     */
    public function show(Upload $upload)
    {
        return response()->json([
            'data' => $upload->load('uploadDocuments')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaveUploadRequest $request
     * @param Upload $upload
     * @return JsonResponse
     */
    public function update(SaveUploadRequest $request, Upload $upload)
    {
        try {
            $deletedFiles = [];

            DB::transaction(function () use ($request, $upload) {
                if (optional($upload->booking)->exists()) {
                    $upload->booking()->update([
                        'booking_type_id' => $request->input('booking_type_id'),
                        'customer_id' => $request->input('customer_id'),
                    ]);
                }

                $upload->fill($request->input());
                $upload->save();

                foreach ($request->input('documents') as &$document) {
                    $document['document_date'] = Carbon::parse($document['document_date'])->format('Y-m-d');
                    $uploadDocument = $upload->uploadDocuments()->updateOrCreate(
                        ['document_type_id' => $document['document_type_id']],
                        $document
                    );

                    // get and delete excluded files
                    $excluded = collect($document['files'])->filter(function ($file) {
                        return !empty($file['id']);
                    });
                    $deletedFiles = $uploadDocument->uploadDocumentFiles()->whereNotIn('id', $excluded->pluck('id'))->get();
                    UploadDocumentFile::destroy($deletedFiles->pluck('id'));

                    foreach ($document['files'] as $file) {
                        $existingFile = [
                            'src' => $file['src'],
                            'file_name' => $file['file_name']
                        ];
                        if (empty($file['id'])) {
                            $existingFile = $upload->moveUploadedFile($file);
                        }
                        $uploadDocument->uploadDocumentFiles()->updateOrCreate(
                            ['id' => data_get($file, 'id')],
                            $existingFile
                        );
                    }
                }
            });

            foreach ($deletedFiles as $deletedFile) {
                if (!empty($deletedFile->src)) {
                    Storage::disk('public')->delete($deletedFile->src);
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => $upload->load('uploadDocuments'),
                'message' => __("Upload document :number successfully updated", [
                    'number' => $upload->upload_number
                ])
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("Update upload :number failed", [
                    'number' => $upload->upload_number
                ])
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Upload $upload
     * @return JsonResponse
     */
    public function destroy(Upload $upload)
    {
        try {
            $upload->delete();
            return response()->json([
                'status' => 'success',
                'data' => $upload,
                'message' => __("Upload document :number successfully deleted", [
                    'number' => $upload->upload_number
                ])
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("Delete upload document :number failed", [
                    'number' => $upload->upload_number
                ])
            ], 500);
        }
    }

    /**
     * Validate upload.
     *
     * @param Upload $upload
     * @return RedirectResponse
     */
    public function validateUpload(Upload $upload)
    {
        return DB::transaction(function () use ($upload) {
            $upload->status = Upload::STATUS_VALIDATED;
            $upload->save();

            $upload->statusHistories()->create([
                'status' => Upload::STATUS_VALIDATED,
                'description' => 'Validate upload documents'
            ]);

            broadcast(new UploadValidatedEvent($upload))->toOthers();

            return response()->json([
                'status' => 'success',
                'data' => $upload,
                'message' => __("Upload document :number successfully validated and ready to booked", [
                    'number' => $upload->upload_number
                ])
            ]);
        });
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
            return response()->json([
                'status' => 'error',
                'message' => __("Upload file failed")
            ]);
        }

        $originalName = $file->getClientOriginalName();
        $extension = $file->extension();

        return response()->json([
            'status' => 'success',
            'data' => [
                'path' => $path,
                'uploaded_name' => basename($path),
                'original_name' => $originalName,
                'extension' => $extension,
            ]
        ]);
    }
}
