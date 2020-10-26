<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\UploadDocument;
use App\Models\UploadDocumentFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UploadDocumentFileController extends Controller
{
    /**
     * Download the specified resource.
     *
     * @param Upload $upload
     * @param UploadDocument $document
     * @param UploadDocumentFile $file
     * @return BinaryFileResponse
     */
    public function download(Upload $upload, UploadDocument $document, UploadDocumentFile $file)
    {
        return Storage::download($file->src);
    }

    /**
     * Display the specified resource.
     *
     * @param Upload $upload
     * @param UploadDocument $document
     * @param UploadDocumentFile $file
     * @return BinaryFileResponse
     */
    public function preview(Upload $upload, UploadDocument $document, UploadDocumentFile $file)
    {
        return response()->file(storage_path('app/' . $file->src));
    }
}
