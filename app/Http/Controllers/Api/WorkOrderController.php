<?php

namespace App\Http\Controllers\Api;

use App\Events\JobAssignedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveWorkOrderRequest;
use App\Models\DeliveryOrder;
use App\Models\WorkOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class WorkOrderController extends Controller
{
    /**
     * WorkOrderController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(WorkOrder::class);
    }

    /**
     * Display a listing of the work order.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $workOrders = WorkOrder::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'))
            ->paginate();

        return response()->json($workOrders);
    }

    /**
     * Store a newly created work order in storage.
     *
     * @param SaveWorkOrderRequest $request
     * @return JsonResponse
     */
    public function store(SaveWorkOrderRequest $request)
    {
        return DB::transaction(function () use ($request) {
            if (empty($request->has('delivery_order_id'))) {
                $workOrder = WorkOrder::create($request->input());
            } else {
                $request->merge(['job_type' => WorkOrder::TYPE_UNLOADING]);
                $deliveryOrder = DeliveryOrder::find($request->input('delivery_order_id'));
                $workOrder = $deliveryOrder->booking->workOrders()->create($request->only(['user_id', 'job_type', 'description']));
            }

            $workOrder->workOrderContainers()->createMany($request->input('containers', []));
            $workOrder->workOrderGoods()->createMany($request->input('goods', []));

            $workOrder->statusHistories()->create([
                'status' => WorkOrder::STATUS_QUEUED,
                'description' => 'Initial job creation'
            ]);

            $request->whenHas('user_id', function ($userId) use ($workOrder) {
                if (!empty($userId)) {
                    event(new JobAssignedEvent($workOrder));
                }
            });

            return response()->json([
                "status" => "success",
                'data' => $workOrder->load(['workOrderContainers', 'workOrderGoods']),
                "message" => __("Work order :number successfully created", [
                    'number' => $workOrder->job_number
                ])
            ]);
        });
    }

    /**
     * Display the specified work order.
     *
     * @param WorkOrder $workOrder
     * @return JsonResponse
     */
    public function show(WorkOrder $workOrder)
    {
        return response()->json($workOrder);
    }

    /**
     * Update the specified work order in storage.
     *
     * @param SaveWorkOrderRequest $request
     * @param WorkOrder $workOrder
     * @return JsonResponse
     */
    public function update(SaveWorkOrderRequest $request, WorkOrder $workOrder)
    {
        DB::transaction(function () use ($request, $workOrder) {
            $workOrder->fill($request->input())->save();

            // sync work order containers
            $excluded = collect($request->input('containers', []))->filter(function ($container) {
                return !empty($container['id']);
            });
            $workOrder->workOrderContainers()->whereNotIn('id', $excluded->pluck('id'))->delete();
            foreach ($request->input('containers', []) as $container) {
                $workOrder->workOrderContainers()->updateOrCreate(
                    ['id' => data_get($container, 'id')],
                    $container
                );
            }

            // sync work order goods
            $excluded = collect($request->input('goods', []))->filter(function ($item) {
                return !empty($item['id']);
            });
            $workOrder->workOrderGoods()->whereNotIn('id', $excluded->pluck('id'))->delete();
            foreach ($request->input('goods', []) as $item) {
                $workOrder->workOrderGoods()->updateOrCreate(
                    ['id' => data_get($item, 'id')],
                    $item
                );
            }
        });

        if (data_get($workOrder->getChanges(), 'user_id')) {
            event(new JobAssignedEvent($workOrder));
        }

        return response()->json([
            "status" => "success",
            'data' => $workOrder->load(['workOrderContainers', 'workOrderGoods']),
            "message" => __("Work order :number successfully updated", [
                'number' => $workOrder->job_number
            ])
        ]);
    }

    /**
     * Remove the specified work order from storage.
     *
     * @param WorkOrder $workOrder
     * @return JsonResponse
     */
    public function destroy(WorkOrder $workOrder)
    {
        try {
            $workOrder->delete();
            return response()->json([
                'status' => 'success',
                'data' => $workOrder,
                'message' => __("Work order :number successfully deleted", [
                    'number' => $workOrder->job_number
                ])
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("Delete work order :number failed", [
                    'number' => $workOrder->job_number
                ])
            ], 500);
        }
    }
}
