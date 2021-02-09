<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveDeliveryOrderRequest;
use App\Models\DeliveryOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

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
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $deliveryOrders = DeliveryOrder::with(['deliveryOrderContainers', 'deliveryOrderGoods'])
            ->q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'))
            ->paginate();

        return response()->json($deliveryOrders);
    }

    /**
     * Store a newly created delivery order in storage.
     *
     * @param SaveDeliveryOrderRequest $request
     * @return JsonResponse
     */
    public function store(SaveDeliveryOrderRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $deliveryOrder = DeliveryOrder::create($request->input());

            $deliveryOrder->deliveryOrderContainers()->createMany($request->input('containers', []));
            $deliveryOrder->deliveryOrderGoods()->createMany($request->input('goods', []));

            return response()->json([
                'status' => 'success',
                'data' => $deliveryOrder->load(['deliveryOrderContainers', 'deliveryOrderGoods']),
                'message' => __("Delivery order :number successfully created", [
                    'number' => $deliveryOrder->delivery_number
                ])
            ]);
        });
    }

    /**
     * Display the specified delivery order.
     *
     * @param DeliveryOrder $deliveryOrder
     * @return JsonResponse
     */
    public function show(DeliveryOrder $deliveryOrder)
    {
        return response()->json([
            'data' => $deliveryOrder->load(['deliveryOrderContainers', 'deliveryOrderGoods']),
        ]);
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

            // sync delivery containers
            $excluded = collect($request->input('containers', []))->filter(function ($container) {
                return !empty($container['id']);
            });
            $deliveryOrder->deliveryOrderContainers()->whereNotIn('id', $excluded->pluck('id'))->delete();
            foreach ($request->input('containers', []) as $container) {
                $deliveryOrder->deliveryOrderContainers()->updateOrCreate(
                    ['id' => data_get($container, 'id')],
                    $container
                );
            }

            // sync delivery goods
            $excluded = collect($request->input('goods', []))->filter(function ($item) {
                return !empty($item['id']);
            });
            $deliveryOrder->deliveryOrderGoods()->whereNotIn('id', $excluded->pluck('id'))->delete();
            foreach ($request->input('goods', []) as $item) {
                $deliveryOrder->deliveryOrderGoods()->updateOrCreate(
                    ['id' => data_get($item, 'id')],
                    $item
                );
            }

            return response()->json([
                'status' => 'success',
                'data' => $deliveryOrder->load(['deliveryOrderContainers', 'deliveryOrderGoods']),
                'message' => __("Delivery order :number successfully updated", [
                    'number' => $deliveryOrder->delivery_number
                ])
            ]);
        });
    }

    /**
     * Remove the specified delivery order from storage.
     *
     * @param DeliveryOrder $deliveryOrder
     * @return JsonResponse
     */
    public function destroy(DeliveryOrder $deliveryOrder)
    {
        try {
            $deliveryOrder->delete();
            return response()->json([
                'status' => 'success',
                'data' => $deliveryOrder,
                'message' => __("Delivery order :number successfully deleted", [
                    'number' => $deliveryOrder->delivery_number
                ])
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("Delete delivery order :number failed", [
                    'number' => $deliveryOrder->delivery_number
                ])
            ], 500);
        }
    }
}
