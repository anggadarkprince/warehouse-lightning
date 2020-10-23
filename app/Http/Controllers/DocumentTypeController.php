<?php

namespace App\Http\Controllers;

use App\Export\Exporter;
use App\Http\Requests\SaveDocumentTypeRequest;
use App\Models\DocumentType;
use App\Export\CollectionExporter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class DocumentTypeController extends Controller
{
    /**
     * DocumentTypeController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(DocumentType::class);
    }

    /**
     * Display a listing of the document type.
     *
     * @param Request $request
     * @param CollectionExporter $exporter
     * @return View|BinaryFileResponse
     */
    public function index(Request $request, CollectionExporter $exporter)
    {
        $documentTypes = DocumentType::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        if ($request->get('export')) {
            $exportPath = $exporter->simpleExportToExcel($documentTypes->get(), [
                'title' => 'Document type data',
                'excludes' => ['id', 'deleted_at']
            ]);
            return response()
                ->download(Storage::disk('local')->path($exportPath), 'Document Type.xlsx')
                ->deleteFileAfterSend(true);
        } else {
            $documentTypes = $documentTypes->paginate();
            return view('document-type.index', compact('documentTypes'));
        }
    }

    /**
     * Show the form for creating a new document type.
     *
     * @return View
     */
    public function create()
    {
        return view('document-type.create');
    }

    /**
     * Store a newly created document type in storage.
     *
     * @param SaveDocumentTypeRequest $request
     * @return RedirectResponse
     */
    public function store(SaveDocumentTypeRequest $request)
    {
        $documentType = DocumentType::create($request->validated());

        return redirect()->route('document-types.index')->with([
            "status" => "success",
            "message" => "Document type {$documentType->document_name} successfully created"
        ]);
    }

    /**
     * Display the specified document type.
     *
     * @param DocumentType $documentType
     * @return View
     */
    public function show(DocumentType $documentType)
    {
        return view('document-type.show', compact('documentType'));
    }

    /**
     * Show the form for editing the specified document type.
     *
     * @param DocumentType $documentType
     * @return View
     */
    public function edit(DocumentType $documentType)
    {
        return view('document-type.edit', compact('documentType'));
    }

    /**
     * Update the specified document type in storage.
     *
     * @param SaveDocumentTypeRequest $request
     * @param DocumentType $documentType
     * @return RedirectResponse
     */
    public function update(SaveDocumentTypeRequest $request, DocumentType $documentType)
    {
        $documentType->fill($request->validated());
        $documentType->save();

        return redirect()->route('document-types.index')->with([
            "status" => "success",
            "message" => "Document type {$documentType->document_name} successfully updated"
        ]);
    }

    /**
     * Remove the specified document type from storage.
     *
     * @param DocumentType $documentType
     * @return RedirectResponse
     */
    public function destroy(DocumentType $documentType)
    {
        try {
            $documentType->delete();
            return redirect()->route('document-types.index')->with([
                "status" => "warning",
                "message" => "Document type {$documentType->document_name} successfully deleted"
            ]);
        } catch (Throwable $e) {
            return redirect()->back()->with([
                "status" => "failed",
                "message" => "Delete document type failed"
            ]);
        }
    }
}
