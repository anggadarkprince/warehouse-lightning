<?php

namespace App\Http\Controllers\Api;

use App\Exports\CollectionExporter;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveDocumentTypeRequest;
use App\Models\DocumentType;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $documentTypes = DocumentType::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        $documentTypes = $documentTypes->paginate();

        return response()->json($documentTypes);
    }


    /**
     * Store a newly created document type in storage.
     *
     * @param SaveDocumentTypeRequest $request
     * @return JsonResponse
     */
    public function store(SaveDocumentTypeRequest $request)
    {
        try {
            $documentType = DocumentType::create($request->validated());
            return response()->json([
                'status' => 'success',
                'data' => $documentType,
                'message' => "Document type successfully created"
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errorInfo ?: 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Update the specified document type in storage.
     *
     * @param SaveDocumentTypeRequest $request
     * @param DocumentType $documentType
     * @return JsonResponse
     */
    public function update(SaveDocumentTypeRequest $request, DocumentType $documentType)
    {
        try {
            $documentType->fill($request->validated());
            $documentType->saveOrFail();
            return response()->json([
                'status' => 'success',
                'data' => $documentType,
                'message' => "Document type successfully updated"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Remove the specified document type from storage.
     *
     * @param DocumentType $documentType
     * @return JsonResponse
     */
    public function destroy(DocumentType $documentType)
    {
        try {
            $documentType->delete();
            return response()->json([
                'status' => 'success',
                'data' => $documentType,
                'message' => "Document type successfully deleted"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }
}
