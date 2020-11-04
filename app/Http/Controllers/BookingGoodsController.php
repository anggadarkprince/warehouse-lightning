<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingGoodsController extends Controller
{
    /**
     * Get booking containers.
     *
     * @param Request $request
     * @param Booking $booking
     * @return JsonResponse
     */
    public function index(Request $request, Booking $booking)
    {
        if ($request->acceptsJson()) {
            return response()->json([
                'goods' => $booking->bookingGoods()->with('goods')->get()
            ]);
        } else {
            return abort(400);
        }
    }
}
