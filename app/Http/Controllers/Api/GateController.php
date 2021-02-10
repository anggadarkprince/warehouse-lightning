<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\DeliveryOrder;
use App\Models\WorkOrder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GateController extends Controller
{
    /**
     * Show gate search data and work orders.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', WorkOrder::class);

        $code = $request->get('code');

        if (!empty($code)) {
            $parseCode = explode('-', $code);
            if (count($parseCode) > 0) {
                switch ($parseCode[0]) {
                    case 'DI':
                    case 'DO':
                        return $this->scanDeliveryOrder($code);
                    case 'BI':
                    case 'BO':
                        return $this->scanBooking($code);
                    default:
                        return response()->json([
                            'status' => 'error',
                            'message' => __("Code number :code is not recognized", [
                                'code' => $code
                            ])
                        ], 422);
                }
            }
        }

        return response()->json([
            'data' => [],
        ]);
    }

    /**
     * Show delivery order data.
     *
     * @param $code
     * @return JsonResponse
     */
    private function scanDeliveryOrder($code)
    {
        $deliveryOrder = DeliveryOrder::where('delivery_number', $code)->firstOrFail();

        return response()->json([
            'data' => compact('deliveryOrder'),
        ]);
    }

    /**
     * Show booking data.
     *
     * @param $code
     * @return JsonResponse
     */
    private function scanBooking($code)
    {
        $booking = Booking::where('booking_number', $code)->firstOrFail();

        return response()->json([
            'data' => compact('booking'),
        ]);
    }
}
