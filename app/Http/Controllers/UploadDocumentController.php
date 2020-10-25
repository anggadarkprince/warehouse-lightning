<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\UploadDocument;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UploadDocumentController extends Controller
{
    /**
     * Display a listing of the document.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new document.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created document in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

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
     * Show the form for editing the specified document.
     *
     * @param UploadDocument $uploadDocument
     * @return \Illuminate\Http\Response
     */
    public function edit(UploadDocument $uploadDocument)
    {
        //
    }

    /**
     * Update the specified document in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param UploadDocument $uploadDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UploadDocument $uploadDocument)
    {
        //
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
            // Name of our archive to download
            $zipFile = storage_path("app/exports/temp/{$document->documentType->document_name}.zip");

            // Initializing PHP class
            $zip = new \ZipArchive();
            $zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            foreach ($document->uploadDocumentFiles as $file) {
                // Adding file: second parameter is what will the path inside of the archive
                $zip->addFile(storage_path('app/' . $file->src), basename($file->src));
            }

            $zip->close();

            // We return the file immediately after download
            return response()->download($zipFile)->deleteFileAfterSend(true);
        } else {
            return Storage::download($document->uploadDocumentFiles->first()->src);
        }
    }
}