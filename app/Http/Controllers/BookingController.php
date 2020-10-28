<?php

namespace App\Http\Controllers;

use App\Exports\CollectionExporter;
use App\Http\Requests\SaveBookingRequest;
use App\Models\Booking;
use App\Models\BookingType;
use App\Models\Customer;
use App\Models\Upload;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingController extends Controller
{
    /**
     * BookingTypeController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Booking::class);
    }

    /**
     * Display a listing of the booking.
     *
     * @param Request $request
     * @param CollectionExporter $exporter
     * @return View|BinaryFileResponse|StreamedResponse
     */
    public function index(Request $request, CollectionExporter $exporter)
    {
        $bookings = Booking::withCount('bookingContainers as container_total')
            ->withCount('bookingGoods as goods_total')
            ->q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        if ($request->get('export')) {
            return $exporter->streamDownload($bookings->cursor(), [
                'title' => 'Booking Data',
                'fileName' => 'Bookings.xlsx',
                'excludes' => ['id', 'deleted_at'],
            ]);
        } else {
            $bookings = $bookings->paginate();
            return view('bookings.index', compact('bookings'));
        }
    }

    /**
     * Show the form for creating a new booking.
     *
     * @return View
     */
    public function create()
    {
        $customers = Customer::all();
        $uploads = Upload::validated()->get();
        $bookingTypes = BookingType::all();

        return view('bookings.create', compact('customers', 'bookingTypes', 'uploads'));
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param SaveBookingRequest $request
     * @return Response|RedirectResponse
     */
    public function store(SaveBookingRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $booking = Booking::create($request->input());

            return redirect()->route('bookings.index')->with([
                "status" => "success",
                "message" => "Booking {$booking->booking_number} successfully created"
            ]);
        });
    }

    /**
     * Display the specified booking.
     *
     * @param Booking $booking
     * @return View
     */
    public function show(Booking $booking)
    {
        return view('bookings.view', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     *
     * @param Booking $booking
     * @return View
     */
    public function edit(Booking $booking)
    {
        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified booking in storage.
     *
     * @param SaveBookingRequest $request
     * @param Booking $booking
     * @return Response|RedirectResponse
     */
    public function update(SaveBookingRequest $request, Booking $booking)
    {
        return DB::transaction(function () use ($request, $booking) {
            $booking->fill($request->input());
            $booking->save();

            return redirect()->route('uploads.index')->with([
                "status" => "success",
                "message" => "Booking {$booking->booking_number} successfully updated"
            ]);
        });
    }

    /**
     * Validate booking.
     *
     * @param Booking $booking
     * @return RedirectResponse
     */
    public function validateBooking(Booking $booking)
    {
        $booking->status = Upload::STATUS_VALIDATED;
        $booking->save();

        return redirect()->back()->with([
            "status" => "success",
            "message" => "Booking {$booking->booking_number} successfully validated and ready to deliver"
        ]);
    }

    /**
     * Remove the specified booking from storage.
     *
     * @param Booking $booking
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->back()->with([
            "status" => "warning",
            "message" => "Booking {$booking->booking_number} successfully deleted"
        ]);
    }
}
