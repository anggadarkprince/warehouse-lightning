<?php

namespace App\Http\Controllers;

use App\Exports\CollectionExporter;
use App\Http\Requests\SaveDeliveryOrderRequest;
use App\Models\Booking;
use App\Models\DeliveryOrder;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DeliveryOrderController extends Controller
{
    /**
     * DeliveryOrderController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(DeliveryOrder::class);
    }

    /**
     * Display a listing of the delivery order.
     *
     * @param Request $request
     * @param CollectionExporter $exporter
     * @return View|BinaryFileResponse|StreamedResponse
     */
    public function index(Request $request, CollectionExporter $exporter)
    {
        $deliveryOrders = DeliveryOrder::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        if ($request->get('export')) {
            return $exporter->streamDownload($deliveryOrders->cursor(), [
                'title' => 'Delivery Order Data',
                'fileName' => 'Delivery orders.xlsx',
                'excludes' => ['id', 'deleted_at'],
            ]);
        } else {
            $deliveryOrders = $deliveryOrders->paginate();
            return view('delivery-orders.index', compact('deliveryOrders'));
        }
    }

    /**
     * Show the form for creating a new delivery order.
     *
     * @return View
     */
    public function create()
    {
        $bookings = Booking::validated()->get();

        return view('delivery-orders.create', compact('bookings'));
    }

    /**
     * Store a newly created delivery order in storage.
     *
     * @param SaveDeliveryOrderRequest $request
     * @return Response|RedirectResponse
     */
    public function store(SaveDeliveryOrderRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $deliveryOrder = DeliveryOrder::create($request->input());

            return redirect()->route('delivery-orders.index')->with([
                "status" => "success",
                "message" => "Delivery order {$deliveryOrder->delivery_number} successfully created"
            ]);
        });
    }

    /**
     * Display the specified delivery order.
     *
     * @param DeliveryOrder $deliveryOrder
     * @return View
     */
    public function show(DeliveryOrder $deliveryOrder)
    {
        return view('delivery-orders.show', compact('deliveryOrder'));
    }

    /**
     * Show the form for editing the specified delivery order.
     *
     * @param DeliveryOrder $deliveryOrder
     * @return View
     */
    public function edit(DeliveryOrder $deliveryOrder)
    {
        $bookings = Booking::validated()->orWhere('id', $deliveryOrder->booking_id)->get();

        return view('delivery-orders.edit', compact('deliveryOrder', 'bookings'));
    }

    /**
     * Update the specified delivery order in storage.
     *
     * @param Request $request
     * @param DeliveryOrder $deliveryOrder
     * @return Response
     */
    public function update(Request $request, DeliveryOrder $deliveryOrder)
    {
        return DB::transaction(function () use ($request, $deliveryOrder) {
            $deliveryOrder->fill($request->input())->save();

            return redirect()->route('delivery-orders.index')->with([
                "status" => "success",
                "message" => "Delivery order {$deliveryOrder->delivery_number} successfully updated"
            ]);
        });
    }

    /**
     * Remove the specified delivery order from storage.
     *
     * @param DeliveryOrder $deliveryOrder
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(DeliveryOrder $deliveryOrder)
    {
        $deliveryOrder->delete();

        return redirect()->back()->with([
            "status" => "warning",
            "message" => "Delivery order {$deliveryOrder->delivery_number} successfully deleted"
        ]);
    }
}
