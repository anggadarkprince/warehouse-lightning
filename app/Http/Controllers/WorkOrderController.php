<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Models\WorkOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class WorkOrderController extends Controller
{
    /**
     * Store a newly created work order in storage.
     *
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            if (!$request->filled('job_type')) {
                $request->merge(['job_type' => WorkOrder::TYPE_UNLOADING]);
            }
            $deliveryOrder = DeliveryOrder::find($request->input('delivery_order_id'));
            $workOrder = $deliveryOrder->booking->workOrders()->create($request->only(['user_id', 'job_type', 'description']));

            $workOrder->workOrderContainers()->createMany($request->input('containers', []));
            $workOrder->workOrderGoods()->createMany($request->input('goods', []));

            return redirect()->route('gate.index')->with([
                "status" => "success",
                "message" => "Work order {$workOrder->job_number} successfully created"
            ]);
        });
    }
}
