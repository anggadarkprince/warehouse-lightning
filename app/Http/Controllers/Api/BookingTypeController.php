<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveBookingTypeRequest;
use App\Models\BookingType;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class BookingTypeController extends Controller
{
    /**
     * Display a listing of the booking type.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $bookingTypes = BookingType::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        $bookingTypes = $bookingTypes->paginate();

        return response()->json($bookingTypes);
    }

    /**
     * Store a newly created booking type in storage.
     *
     * @param SaveBookingTypeRequest $request
     * @return JsonResponse
     */
    public function store(SaveBookingTypeRequest $request)
    {
        try {
            $bookingType = BookingType::create($request->validated());
            return response()->json([
                'status' => 'success',
                'data' => $bookingType,
                'message' => "Booking type successfully created"
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errorInfo ?: 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Display the specified booking type.
     *
     * @param BookingType $bookingType
     * @return JsonResponse
     */
    public function show(BookingType $bookingType)
    {
        return response()->json([
            'data' => $bookingType
        ]);
    }

    /**
     * Update the specified booking type in storage.
     *
     * @param SaveBookingTypeRequest $request
     * @param BookingType $bookingType
     * @return JsonResponse
     */
    public function update(SaveBookingTypeRequest $request, BookingType $bookingType)
    {
        try {
            $bookingType->fill($request->validated());
            $bookingType->save();
            return response()->json([
                'status' => 'success',
                'data' => $bookingType,
                'message' => "Booking type successfully updated"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Remove the specified booking type from storage.
     *
     * @param BookingType $bookingType
     * @return JsonResponse
     */
    public function destroy(BookingType $bookingType)
    {
        try {
            $bookingType->delete();
            return response()->json([
                'status' => 'success',
                'data' => $bookingType,
                'message' => "Booking type successfully deleted"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }
}
