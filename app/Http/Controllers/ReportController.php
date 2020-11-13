<?php

namespace App\Http\Controllers;

use App\Exports\CollectionExporter;
use App\Models\Report;
use App\Models\ReportStock;
use App\Models\WorkOrder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Get report inbound.
     *
     * @param Request $request
     * @param Report $report
     * @param CollectionExporter $exporter
     * @return View|BinaryFileResponse|StreamedResponse
     */
    public function inbound(Request $request, Report $report, CollectionExporter $exporter)
    {
        $containerRequest = $request->get('filter') == 'container' ? $request : new Request();
        $containerRequest->merge(['job_type' => WorkOrder::TYPE_UNLOADING]);
        $goodsRequest = $request->get('filter') == 'goods' ? $request : new Request();
        $goodsRequest->merge(['job_type' => WorkOrder::TYPE_UNLOADING]);

        $activityContainers = $report->getActivityContainers($containerRequest);
        $activityGoods = $report->getActivityGoods($goodsRequest);

        if ($containerRequest->get('export')) {
            return $exporter->streamDownload(
                $activityContainers->cursor(), ['title' => 'Inbound Container']
            );
        } else if ($goodsRequest->get('export')) {
            return $exporter->streamDownload(
                $activityGoods->cursor(), ['title' => 'Inbound goods']
            );
        } else {
            $activityContainers = $activityContainers->paginate();
            $activityGoods = $activityGoods->paginate();
            $reportType = 'Inbound';
            return view('report-activities.index', compact('activityContainers', 'activityGoods', 'reportType'));
        }
    }

    /**
     * Get report outbound.
     *
     * @param Request $request
     * @param Report $report
     * @param CollectionExporter $exporter
     * @return View|BinaryFileResponse|StreamedResponse
     */
    public function outbound(Request $request, Report $report, CollectionExporter $exporter)
    {
        $containerRequest = $request->get('filter') == 'container' ? $request : new Request();
        $containerRequest->merge(['job_type' => WorkOrder::TYPE_LOADING]);
        $goodsRequest = $request->get('filter') == 'goods' ? $request : new Request();
        $goodsRequest->merge(['job_type' => WorkOrder::TYPE_LOADING]);

        $activityContainers = $report->getActivityContainers($containerRequest);
        $activityGoods = $report->getActivityGoods($goodsRequest);

        if ($containerRequest->get('export')) {
            return $exporter->streamDownload(
                $activityContainers->cursor(), ['title' => 'Outbound Container']
            );
        } else if ($goodsRequest->get('export')) {
            return $exporter->streamDownload(
                $activityGoods->cursor(), ['title' => 'Outbound goods']
            );
        } else {
            $activityContainers = $activityContainers->paginate();
            $activityGoods = $activityGoods->paginate();
            $reportType = 'Outbound';
            return view('report-activities.index', compact('activityContainers', 'activityGoods', 'reportType'));
        }
    }

    /**
     * Show stock summary.
     *
     * @param Request $request
     * @param ReportStock $report
     * @param CollectionExporter $exporter
     * @return View|BinaryFileResponse|StreamedResponse|JsonResponse
     */
    public function stockSummary(Request $request, ReportStock $report, CollectionExporter $exporter)
    {
        $containerRequest = $request->get('filter') == 'container' ? $request : new Request();
        $goodsRequest = $request->get('filter') == 'goods' ? $request : new Request();

        $stockContainers = $report->getStockContainers($containerRequest);
        $stockGoods = $report->getStockGoods($goodsRequest);

        if ($containerRequest->get('export')) {
            return $exporter->streamDownload(
                $stockContainers->cursor(), ['title' => 'Outbound Container']
            );
        } else if ($goodsRequest->get('export')) {
            return $exporter->streamDownload(
                $stockGoods->cursor(), ['title' => 'Stock goods']
            );
        } else {
            if ($request->wantsJson()) {
                return response()->json([
                    'containers' => $stockContainers->get(),
                    'goods' => $stockGoods->get()
                ]);
            } else {
                $stockContainers = $stockContainers->paginate();
                $stockGoods = $stockGoods->paginate();
                return view('report-stocks.index', compact('stockContainers', 'stockGoods'));
            }
        }
    }
}
