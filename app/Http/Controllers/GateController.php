<?php

namespace App\Http\Controllers;

use App\Exports\CollectionExporter;
use App\Models\Booking;
use App\Models\DeliveryOrder;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GateController extends Controller
{
    /**
     * Show gate search data and work orders.
     *
     * @param Request $request
     * @param CollectionExporter $exporter
     * @return View|BinaryFileResponse|StreamedResponse|RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request, CollectionExporter $exporter)
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
                        return redirect()->route('gate.index')->with([
                            'status' => "failed",
                            "message" => "Code number {$code} is not recognized"
                        ]);
                }
            }
        }

        $workOrders = WorkOrder::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        if ($request->get('export')) {
            return $exporter->streamDownload($workOrders->cursor(), [
                'title' => 'Work Order Data',
                'fileName' => 'Delivery orders.xlsx',
                'excludes' => ['id', 'deleted_at'],
            ]);
        } else {
            $workOrders = $workOrders->paginate();
            return view('gate.index', compact('workOrders'));
        }
    }

    /**
     * Show delivery order data.
     *
     * @param $code
     * @return View|RedirectResponse
     */
    private function scanDeliveryOrder($code)
    {
        $deliveryOrder = DeliveryOrder::where('delivery_number', $code)->first();
        if (empty($deliveryOrder)) {
            return redirect()->route('gate.index')->with([
                'status' => "failed",
                "message" => "Delivery order not found"
            ]);
        }

        $users = User::all();

        return view('gate.delivery-order', compact('deliveryOrder', 'users'));
    }

    /**
     * Show booking data.
     *
     * @param $code
     * @return View|RedirectResponse
     */
    private function scanBooking($code)
    {
        $booking = Booking::where('booking_number', $code)->first();
        if (empty($booking)) {
            return redirect()->route('gate.index')->with([
                'status' => "failed",
                "message" => "Booking not found"
            ]);
        }

        $users = User::all();

        return view('gate.booking', compact('booking', 'users'));
    }
}
