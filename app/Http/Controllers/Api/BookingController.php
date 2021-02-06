<?php

namespace App\Http\Controllers\Api;

use App\Events\BookingValidatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveBookingRequest;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class BookingController extends Controller
{
    /**
     * BookingController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Booking::class);
    }

    /**
     * Display a listing of the booking.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $bookings = Booking::withCount('bookingContainers as container_total')
            ->withCount('bookingGoods as goods_total')
            ->q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'))
            ->paginate();

        return response()->json($bookings);
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param SaveBookingRequest $request
     * @return JsonResponse
     */
    public function store(SaveBookingRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $request->merge([
                'total_gross_weight' => numeric(array_sum(array_column($request->input('goods', []), 'gross_weight'))),
                'total_weight' => numeric(array_sum(array_column($request->input('goods', []), 'weight'))),
            ]);
            $booking = Booking::create($request->input());

            $booking->bookingContainers()->createMany($request->input('containers', []));
            $booking->bookingGoods()->createMany($request->input('goods', []));

            $booking->statusHistories()->create([
                'status' => Booking::STATUS_DRAFT,
                'description' => 'Initial booking'
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $booking,
                'message' => __("Booking :number successfully created", [
                    'number' => $booking->booking_number
                ])
            ]);
        });
    }

    /**
     * Display the specified booking.
     *
     * @param Booking $booking
     * @return JsonResponse
     */
    public function show(Booking $booking)
    {
        return response()->json([
            'data' => $booking->load(['bookingContainers', 'bookingGoods'])
        ]);
    }

    /**
     * Update the specified booking in storage.
     *
     * @param SaveBookingRequest $request
     * @param Booking $booking
     * @return JsonResponse
     */
    public function update(SaveBookingRequest $request, Booking $booking)
    {
        return DB::transaction(function () use ($request, $booking) {
            $request->merge([
                'total_weight' => numeric(array_sum(array_column($request->input('goods', []), 'weight'))),
                'total_gross_weight' => numeric(array_sum(array_column($request->input('goods', []), 'gross_weight'))),
            ]);
            $booking->fill($request->input());
            $booking->save();

            // sync booking containers
            $excluded = collect($request->input('containers', []))->filter(function ($container) {
                return !empty($container['id']);
            });
            $booking->bookingContainers()->whereNotIn('id', $excluded->pluck('id'))->delete();
            foreach ($request->input('containers', []) as $container) {
                $booking->bookingContainers()->updateOrCreate(
                    ['id' => data_get($container, 'id')],
                    $container
                );
            }

            // sync booking goods
            $excluded = collect($request->input('goods', []))->filter(function ($item) {
                return !empty($item['id']);
            });
            $booking->bookingGoods()->whereNotIn('id', $excluded->pluck('id'))->delete();
            foreach ($request->input('goods', []) as $item) {
                $booking->bookingGoods()->updateOrCreate(
                    ['id' => data_get($item, 'id')],
                    $item
                );
            }

            return response()->json([
                'status' => 'success',
                'data' => $booking,
                'message' => __("Booking :number successfully updated", [
                    'number' => $booking->booking_number
                ])
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
        return DB::transaction(function () use ($booking) {
            $booking->status = Booking::STATUS_VALIDATED;
            $booking->save();

            $booking->statusHistories()->create([
                'status' => Booking::STATUS_VALIDATED,
                'description' => 'Validate booking'
            ]);

            broadcast(new BookingValidatedEvent($booking))->toOthers();

            return response()->json([
                'status' => 'success',
                'data' => $booking,
                'message' => __("Booking :number successfully validated and ready to deliver", [
                    'number' => $booking->booking_number
                ])
            ]);
        });
    }

    /**
     * Remove the specified booking from storage.
     *
     * @param Booking $booking
     * @return JsonResponse
     */
    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            return response()->json([
                'status' => 'success',
                'data' => $booking,
                'message' => __("Booking :number successfully deleted", [
                    'number' => $booking->booking_number
                ])
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("Delete booking :number failed", [
                    'number' => $booking->booking_number
                ])
            ], 500);
        }
    }
}
