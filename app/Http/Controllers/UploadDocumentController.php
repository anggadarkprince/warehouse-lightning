<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\UploadDocument;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class UploadDocumentController extends Controller
{
    /**
     * Display the specified document.
     *
     * @param Upload $upload
     * @param UploadDocument $document
     * @return View
     */
    public function show(Upload $upload, UploadDocument $document)
    {
        return view('upload-documents.show', compact('upload', 'document'));
    }

    /**
     * Remove the specified document from storage.
     *
     * @param Upload $upload
     * @param UploadDocument $document
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Upload $upload, UploadDocument $document)
    {
        $document->delete();

        return redirect()->back()->with([
            "status" => "warning",
            "message" => "Document {$document->documentType->document_name} from upload {$upload->upload_number} successfully deleted"
        ]);
    }

    /**
     * Download document files at once.
     *
     * @param Upload $upload
     * @param UploadDocument $document
     * @return BinaryFileResponse|RedirectResponse
     */
    public function download(Upload $upload, UploadDocument $document)
    {
        if ($document->uploadDocumentFiles()->doesntExist()) {
            return redirect()->back(302, [], route('uploads.show', ['upload' => $upload->id]))
                ->with([
                    "status" => "warning",
                    "message" => "No file available to be downloaded"
                ]);
        }

        if ($document->uploadDocumentFiles()->count() > 1) {
            $zipFile = storage_path("app/exports/temp/{$document->documentType->document_name}.zip");

            try {
                $zip = new ZipArchive();
                $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

                foreach ($document->uploadDocumentFiles as $file) {
                    // Adding file: second parameter is what will the path inside of the archive
                    $zip->addFile(storage_path('app/' . $file->src), $file->file_name ?: basename($file->src));
                }

                $zip->close();

                return response()->download($zipFile)->deleteFileAfterSend(true);
            } catch (Exception $e) {
                return redirect()->back()->with([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }

        } else {
            return Storage::download($document->uploadDocumentFiles->first()->src);
        }
    }
}
