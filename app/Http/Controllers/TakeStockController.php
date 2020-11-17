<?php

namespace App\Http\Controllers;

use App\Exports\CollectionExporter;
use App\Http\Requests\SaveTakeStockRequest;
use App\Models\Booking;
use App\Models\ReportStock;
use App\Models\TakeStock;
use Exception;
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
            $takeStock = TakeStock::create($request->input());

            switch ($request->input('type')) {
                case 'CONTAINER':
                    $containers = $reportStock->getStockContainers($request)->get()->map(function ($item) {
                        return (array)$item;
                    })->toArray();
                    $takeStock->takeStockContainers()->createMany($containers);
                    break;
                case 'GOODS':
                    $goods = $reportStock->getStockGoods($request)->get()->map(function ($item) {
                        return (array)$item;
                    })->toArray();
                    $takeStock->takeStockGoods()->createMany($goods);
                    break;
                default:
                    $containers = $reportStock->getStockContainers($request)->get()->map(function ($item) {
                        return (array)$item;
                    })->toArray();
                    $goods = $reportStock->getStockGoods($request)->get()->map(function ($item) {
                        return (array)$item;
                    })->toArray();
                    $takeStock->takeStockContainers()->createMany($containers);
                    $takeStock->takeStockGoods()->createMany($goods);
                    break;
            }

            return redirect()->route('take-stocks.index')->with([
                "status" => "success",
                "message" => "Take stock number {$takeStock->take_stock_number} successfully created and ready to proceed"
            ]);
        });
    }

    /**
     * Validate take stock.
     *
     * @param TakeStock $takeStock
     * @return RedirectResponse
     */
    public function validateTakeStock(TakeStock $takeStock)
    {
        return DB::transaction(function () use ($takeStock) {
            $takeStock->status = TakeStock::STATUS_VALIDATED;
            $takeStock->save();

            $takeStock->statusHistories()->create([
                'status' => TakeStock::STATUS_VALIDATED,
                'description' => 'Validate booking'
            ]);

            return redirect()->back()->with([
                "status" => "success",
                "message" => "Take stock {$takeStock->take_stock_number} successfully validated, stock may changed"
            ]);
        });
    }

    /**
     * Remove the specified take stock from storage.
     *
     * @param  TakeStock $takeStock
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
