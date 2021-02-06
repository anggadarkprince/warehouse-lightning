<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use App\Models\UploadDocument;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Throwable;

class UploadDocumentController extends Controller
{
    /**
     * Display the specified document.
     *
     * @param Upload $upload
     * @param UploadDocument $document
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(Upload $upload, UploadDocument $document)
    {
        $this->authorize('view', $upload);

        $document->load('uploadDocumentFiles');
        return response()->json([
            'data' => compact('upload', 'document'),
        ]);
    }

    /**
     * Remove the specified document from storage.
     *
     * @param Upload $upload
     * @param UploadDocument $document
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Upload $upload, UploadDocument $document)
    {
        $this->authorize('delete', $upload);

        try {
            $document->delete();
            return response()->json([
                'status' => 'success',
                'data' => $document,
                'message' => __("Document :document from upload :upload successfully deleted", [
                    'document' => $document->documentType->document_name,
                    'upload' => $upload->upload_number,
                ])
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("Delete document :document failed", [
                    'document' => $document->documentType->document_name,
                ])
            ], 500);
        }
    }
}
