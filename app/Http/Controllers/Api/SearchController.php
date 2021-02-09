<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\DeliveryOrder;
use App\Models\WorkOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Global search of the application.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $q = $request->get('q');

        $customers = Customer::search($q)->take(5)->get();
        $bookings = Booking::search($q)->take(5)->get();
        $workOrders = WorkOrder::search($q)->take(5)->get();
        $deliveryOrders = DeliveryOrder::search($q)->take(5)->get();

        return response()->json([
            'data' => compact('q', 'customers', 'bookings', 'workOrders', 'deliveryOrders')
        ]);
    }
}
