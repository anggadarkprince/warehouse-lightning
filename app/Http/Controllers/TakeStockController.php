<?php

namespace App\Http\Controllers;

use App\Exports\CollectionExporter;
use App\Http\Requests\SaveTakeStockRequest;
use App\Http\Requests\UpdateTakeStockRequest;
use App\Models\Booking;
use App\Models\ReportStock;
use App\Models\TakeStock;
use App\Models\TakeStockContainer;
use App\Models\TakeStockGoods;
use App\Models\WorkOrder;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
     * Display a listing of the customer.
     *
     * @param Request $request
     * @param CollectionExporter $exporter
     * @return View|BinaryFileResponse|StreamedResponse
     */
    public function index(Request $request, CollectionExporter $exporter)
    {
        $takeStocks = TakeStock::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        if ($request->get('export')) {
            return $exporter->streamDownload($takeStocks->cursor(), [
                'title' => 'Take Stock Data',
                'fileName' => 'Take stocks.xlsx',
                'excludes' => ['id', 'deleted_at'],
            ]);
        } else {
            $takeStocks = $takeStocks->paginate();
            return view('take-stocks.index', compact('takeStocks'));
        }
    }

    /**
     * Show the form for creating a new take stock.
     *
     * @return View
     */
    public function create()
    {
        return view('take-stocks.create');
    }

    /**
     * Store a newly created delivery order in storage.
     *
     * @param SaveTakeStockRequest $request
     * @param ReportStock $reportStock
     * @return Response|RedirectResponse
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

            return redirect()->route('take-stocks.index')->with([
                "status" => "success",
                "message" => "Take stock number {$takeStock->take_stock_number} successfully created and ready to proceed"
            ]);
        });
    }

    /**
     * Display the specified take stock.
     *
     * @param TakeStock $takeStock
     * @return View
     */
    public function show(TakeStock $takeStock)
    {
        return view('take-stocks.show', compact('takeStock'));
    }

    /**
     * Display the specified take stock.
     *
     * @param TakeStock $takeStock
     * @return View
     */
    public function edit(TakeStock $takeStock)
    {
        return view('take-stocks.edit', compact('takeStock'));
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

            return redirect()->route('take-stocks.index')->with([
                "status" => "success",
                "message" => "Take stock {$takeStock->take_stock_number} successfully updated"
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

            return redirect()->route('take-stocks.index')->with([
                'status' => 'success',
                'message' => __('Take stock :number successfully submitted, waiting for validation', ['number' => $takeStock->take_stock_number])
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
    public function validateTakeStock(Request $request, TakeStock $takeStock)
    {
        $this->authorize('validate', $takeStock);

        return DB::transaction(function () use ($request, $takeStock) {
            if ($request->has('refuse')) {
                $takeStock->update(['status' => TakeStock::STATUS_REJECTED]);

                $takeStock->statusHistories()->create([
                    'status' => TakeStock::STATUS_REJECTED,
                    'description' => $request->input('message', 'Take stock is rejected')
                ]);

                return redirect()->route('take-stocks.index')->with([
                    'status' => 'warning',
                    'message' => __('Take stock :number is rejected', ['number' => $takeStock->take_stock_number])
                ]);
            } else {
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

                return redirect()->route('take-stocks.index')->with([
                    'status' => 'success',
                    'message' => __('Take stock :number is validated', ['number' => $takeStock->take_stock_number])
                ]);
            }
        });
    }

    /**
     * Remove the specified take stock from storage.
     *
     * @param TakeStock $takeStock
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(TakeStock $takeStock)
    {
        $takeStock->delete();

        return redirect()->route('take-stocks.index')->with([
            "status" => "warning",
            "message" => "Take stock {$takeStock->take_stock_number} successfully deleted"
        ]);
    }
}
