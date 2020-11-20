<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Dashboard;
use App\Models\WorkOrder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a dashboard.
     *
     * @param Dashboard $dashboard
     * @return View
     */
    public function index(Dashboard $dashboard)
    {
        $data = [
            'bookingTotal' => Booking::validated()->count(),
            'deliveryOrderTotal' => Booking::validated()->count(),
            'queueJobTotal' => WorkOrder::status(WorkOrder::STATUS_OUTSTANDING)->count(),
            'jobTotal' => WorkOrder::count(),
            'bookingWeekly' => $dashboard->getTotalWeeklyBooking()->take(10)->get(),
            'deliveryWeekly' => $dashboard->getTotalWeeklyDelivery()->take(10)->get(),
            'jobWeekly' => $dashboard->getTotalWeeklyJob()->take(10)->get(),
        ];

        return view('dashboard.index', $data);
    }
}
