<?php

namespace App\Http\Controllers;

use App\Exports\CollectionExporter;
use App\Models\Report;
use App\Models\WorkOrder;
use Illuminate\Contracts\View\View;
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

        if ($containerRequest->get('export')) {
            return $exporter->streamDownload($report->getActivityContainers($containerRequest)->cursor(), [
                'title' => 'Inbound Container',
                'fileName' => 'Inbound containers.xlsx',
            ]);
        } else if ($goodsRequest->get('export')) {
            return $exporter->streamDownload($report->getActivityGoods($goodsRequest)->cursor(), [
                'title' => 'Inbound goods',
                'fileName' => 'Inbound goods.xlsx',
            ]);
        } else {
            $activityContainers = $report->getActivityContainers($containerRequest)->paginate();
            $activityGoods = $report->getActivityGoods($goodsRequest)->paginate();
            $reportType = 'Inbound';
            return view('reports-activity.index', compact('activityContainers', 'activityGoods', 'reportType'));
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

        if ($containerRequest->get('export')) {
            return $exporter->streamDownload($report->getActivityContainers($containerRequest)->cursor(), [
                'title' => 'Outbound Container',
                'fileName' => 'Outbound containers.xlsx',
            ]);
        } else if ($goodsRequest->get('export')) {
            return $exporter->streamDownload($report->getActivityGoods($goodsRequest)->cursor(), [
                'title' => 'Outbound goods',
                'fileName' => 'Outbound goods.xlsx',
            ]);
        } else {
            $activityContainers = $report->getActivityContainers($containerRequest)->paginate();
            $activityGoods = $report->getActivityGoods($goodsRequest)->paginate();
            $reportType = 'Outbound';
            return view('reports-activity.index', compact('activityContainers', 'activityGoods', 'reportType'));
        }
    }
}
