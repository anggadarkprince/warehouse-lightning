<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveTakeStockRequest;
use App\Http\Requests\UpdateTakeStockRequest;
use App\Models\ReportStock;
use App\Models\TakeStock;
use App\Models\TakeStockContainer;
use App\Models\TakeStockGoods;
use App\Models\WorkOrder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class TakeStockController extends Controller
{
    /**
     * TakeStockController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(TakeStock::class);
    }

    /**
     * Display a listing of the take stocks.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $takeStocks = TakeStock::withCount('takeStockContainers as container_total')
            ->withCount('takeStockGoods as goods_total')
            ->q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'))
            ->paginate();

        return response()->json($takeStocks);
    }

    /**
     * Store a newly created delivery order in storage.
     *
     * @param SaveTakeStockRequest $request
     * @param ReportStock $reportStock
     * @return JsonResponse
     */
    public function store(SaveTakeStockRequest $request, ReportStock $reportStock)
    {
        return DB::transaction(function () use ($request, $reportStock) {
            $takeStock = TakeStock::create($request->merge(['status' => TakeStock::STATUS_PENDING])->input());

            // put container stock into take stock's container
            if (in_array($request->input('type'), ['CONTAINER', 'ALL'])) {
                $containers = $reportStock->getStockContainers($request)->get()->map(function ($container) {
                    $container->revision_quantity = $container->quantity;
                    return collect($container)->toArray();
                });
                $takeStock->takeStockContainers()->createMany($containers->toArray());
            }

            // put goods stock into take stock's container
            if (in_array($request->input('type'), ['GOODS', 'ALL'])) {
                $goods = $reportStock->getStockGoods($request)->get()->map(function ($item) {
                    $item->revision_unit_quantity = $item->unit_quantity;
                    $item->revision_package_quantity = $item->package_quantity;
                    $item->revision_weight = $item->weight;
                    $item->revision_gross_weight = $item->gross_weight;
                    return collect($item)->toArray();
                });
                $takeStock->takeStockGoods()->createMany($goods->toArray());
            }

            $takeStock->statusHistories()->create([
                'status' => TakeStock::STATUS_PENDING,
                'description' => 'Initial generated take stock'
            ]);

            return response()->json([
                "status" => "success",
                "data" => $takeStock,
                "message" => __("Take stock :number successfully created and ready to proceed", [
                    "number" => $takeStock->take_stock_number
                ])
            ]);
        });
    }

    /**
     * Display the specified take stock.
     *
     * @param TakeStock $takeStock
     * @return JsonResponse
     */
    public function show(TakeStock $takeStock)
    {
        return response()->json([
            "data" => $takeStock
        ]);
    }

    /**
     * Update the specified booking in storage.
     *
     * @param UpdateTakeStockRequest $request
     * @param TakeStock $takeStock
     * @return Response|RedirectResponse
     */
    public function update(UpdateTakeStockRequest $request, TakeStock $takeStock)
    {
        return DB::transaction(function () use ($request, $takeStock) {
            $takeStock->update(['status' => TakeStock::STATUS_IN_PROCESS]);

            foreach ($request->input('containers', []) as $container) {
                TakeStockContainer::find($container['id'])->update($container);
            }

            foreach ($request->input('goods', []) as $item) {
                TakeStockGoods::find($item['id'])->update($item);
            }

            $takeStock->statusHistories()->create([
                'status' => TakeStock::STATUS_IN_PROCESS,
                'description' => 'Update take stock'
            ]);

            return response()->json([
                "status" => "success",
                "data" => $takeStock,
                "message" => __("Take stock :number successfully updated", [
                    "number" => $takeStock->take_stock_number
                ])
            ]);
        });
    }

    /**
     * Complete job data and redirect to index list.
     *
     * @param Request $request
     * @param TakeStock $takeStock
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function submit(Request $request, TakeStock $takeStock)
    {
        $this->authorize('update', $takeStock);

        return DB::transaction(function () use ($request, $takeStock) {
            $takeStock->update(['status' => TakeStock::STATUS_SUBMITTED]);
            $takeStock->statusHistories()->create([
                'status' => TakeStock::STATUS_SUBMITTED,
                'description' => 'Take stock is submitted'
            ]);

            return response()->json([
                "status" => "success",
                "data" => $takeStock,
                "message" => __("Take stock :number successfully submitted, waiting for validation", [
                    "number" => $takeStock->take_stock_number
                ])
            ]);
        });
    }

    /**
     * Remove the specified take stock from storage.
     *
     * @param TakeStock $takeStock
     * @return JsonResponse
     */
    public function destroy(TakeStock $takeStock)
    {
        try {
            $takeStock->delete();
            return response()->json([
                "status" => "success",
                "data" => $takeStock,
                "message" => __("Take stock :number successfully deleted", [
                    "number" => $takeStock->take_stock_number
                ])
            ]);
        } catch (Throwable $e) {
            return response()->json([
                "status" => "error",
                "message" => __("Delete take stock :number failed", [
                    "number" => $takeStock->take_stock_number
                ])
            ], 500);
        }
    }

    /**
     * Complete job data and redirect to index list.
     *
     * @param Request $request
     * @param TakeStock $takeStock
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function validateTakeStock(Request $request, TakeStock $takeStock)
    {
        $this->authorize('validate', $takeStock);

        return DB::transaction(function () use ($request, $takeStock) {
            $takeStock->update(['status' => TakeStock::STATUS_VALIDATED]);

            $containers = $takeStock->takeStockContainers->filter(function ($container) {
                return $container->quantity != $container->revision_quantity;
            });
            $containers->groupBy('booking_id')->each(function ($containerData, $key) use ($request, $takeStock) {
                $workOrder = WorkOrder::create([
                    'booking_id' => $key,
                    'user_id' => $request->user()->id,
                    'job_type' => WorkOrder::TYPE_TAKE_STOCK,
                    'taken_at' => $takeStock->created_at,
                    'completed_at' => $takeStock->updated_at,
                    'status' => WorkOrder::STATUS_VALIDATED,
                    'description' => $takeStock->description,
                ]);

                $workOrder->workOrderContainers()->createMany($containerData->map(function ($container) {
                    $container->quantity = $container->revision_quantity - $container->quantity;
                    $container->description = $container->revision_description;
                    return $container;
                })->toArray());
            });

            $goods = $takeStock->takeStockGoods->filter(function ($item) {
                return $item->unit_quantity != $item->revision_unit_quantity
                    || $item->package_quantity != $item->revision_package_quantity
                    || $item->weight != $item->revision_weight
                    || $item->gross_weight != $item->revision_gross_weight;
            });
            $goods->groupBy('booking_id')->each(function ($itemData, $key) use ($request, $takeStock) {
                $workOrder = WorkOrder::create([
                    'booking_id' => $key,
                    'user_id' => $request->user()->id,
                    'job_type' => WorkOrder::TYPE_TAKE_STOCK,
                    'taken_at' => $takeStock->created_at,
                    'completed_at' => $takeStock->updated_at,
                    'status' => WorkOrder::STATUS_VALIDATED,
                    'description' => $takeStock->description ?: '-',
                ]);

                $workOrder->workOrderGoods()->createMany($itemData->map(function ($item) {
                    $item->unit_quantity = $item->revision_unit_quantity - $item->unit_quantity;
                    $item->package_quantity = $item->revision_package_quantity - $item->package_quantity;
                    $item->weight = $item->revision_weight - $item->weight;
                    $item->gross_weight = $item->revision_gross_weight - $item->gross_weight;
                    $item->description = $item->revision_description;
                    return $item;
                })->toArray());
            });

            $takeStock->statusHistories()->create([
                'status' => TakeStock::STATUS_VALIDATED,
                'description' => $request->input('message', 'Take stock is validated')
            ]);

            return response()->json([
                "status" => "success",
                "data" => $takeStock,
                "message" => __("Take stock :number successfully validated", [
                    "number" => $takeStock->take_stock_number
                ])
            ]);
        });
    }

    /**
     * Complete job data and redirect to index list.
     *
     * @param Request $request
     * @param TakeStock $takeStock
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function rejectTakeStock(Request $request, TakeStock $takeStock)
    {
        $this->authorize('validate', $takeStock);

        return DB::transaction(function () use ($request, $takeStock) {
            $takeStock->update(['status' => TakeStock::STATUS_REJECTED]);

            $takeStock->statusHistories()->create([
                'status' => TakeStock::STATUS_REJECTED,
                'description' => $request->input('message', 'Take stock is rejected')
            ]);

            return response()->json([
                "status" => "success",
                "data" => $takeStock,
                "message" => __("Take stock :number successfully rejected", [
                    "number" => $takeStock->take_stock_number
                ])
            ]);
        });
    }
}
