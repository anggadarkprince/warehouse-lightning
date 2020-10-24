<?php

namespace App\Http\Controllers;

use App\Exports\CollectionExporter;
use App\Models\BookingType;
use App\Models\Customer;
use App\Models\Upload;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        return view('uploads.create', compact('customers', 'bookingTypes'));
    }

    /**
     * Store a newly created document in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
     * @param  \Illuminate\Http\Request  $request
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
}
