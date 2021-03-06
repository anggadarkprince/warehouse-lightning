<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        return response()->json([
            'goods' => $booking->bookingGoods()->with('goods')->get()
        ]);
    }
}
