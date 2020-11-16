<?php

namespace App\Http\Controllers;

use App\Exports\CollectionExporter;
use App\Models\TakeStock;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * Validate booking.
     *
     * @param TakeStock $takeStock
     * @return RedirectResponse
     */
    public function validateBooking(TakeStock $takeStock)
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
