<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveBookingTypeRequest;
use App\Models\BookingType;
use App\Models\Export\CollectionExporter;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BookingTypeController extends Controller
{
    /**
     * BookingTypeController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(BookingType::class);
    }

    /**
     * Display a listing of the booking type.
     *
     * @param Request $request
     * @return View|BinaryFileResponse
     */
    public function index(Request $request)
    {
        $bookingTypes = BookingType::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        if ($request->get('export')) {
            $exportPath = CollectionExporter::simpleExportToExcel($bookingTypes->get(), 'Document types');
            return response()
                ->download(Storage::disk('local')->path($exportPath))
                ->deleteFileAfterSend(true);
        } else {
            $bookingTypes = $bookingTypes->paginate();
            return view('booking-type.index', compact('bookingTypes'));
        }
    }

    /**
     * Show the form for creating a new booking type.
     *
     * @return View
     */
    public function create()
    {
        return view('booking-type.create');
    }

    /**
     * Store a newly created booking type in storage.
     *
     * @param  SaveBookingTypeRequest $request
     * @return RedirectResponse
     */
    public function store(SaveBookingTypeRequest $request)
    {
        $bookingType = BookingType::create($request->validated());

        return redirect()->route('booking-types.index')->with([
            "status" => "success",
            "message" => "Document type {$bookingType->booking_name} successfully created"
        ]);
    }

    /**
     * Display the specified booking type.
     *
     * @param  BookingType $bookingType
     * @return View
     */
    public function show(BookingType $bookingType)
    {
        return view('booking-type.show', compact('bookingType'));
    }

    /**
     * Show the form for editing the specified booking type.
     *
     * @param  BookingType $bookingType
     * @return View
     */
    public function edit(BookingType $bookingType)
    {
        return view('booking-type.edit', compact('bookingType'));
    }

    /**
     * Update the specified booking type in storage.
     *
     * @param  SaveBookingTypeRequest $request
     * @param  BookingType $bookingType
     * @return RedirectResponse
     */
    public function update(SaveBookingTypeRequest $request, BookingType $bookingType)
    {
        $bookingType->fill($request->validated());
        $bookingType->save();

        return redirect()->route('booking-types.index')->with([
            "status" => "success",
            "message" => "Booking type {$bookingType->booking_name} successfully updated"
        ]);
    }

    /**
     * Remove the specified booking type from storage.
     *
     * @param BookingType $bookingType
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(BookingType $bookingType)
    {
        $bookingType->delete();

        return redirect()->route('booking-types.index')->with([
            "status" => "warning",
            "message" => "Document type {$bookingType->document_name} successfully deleted"
        ]);
    }
}
