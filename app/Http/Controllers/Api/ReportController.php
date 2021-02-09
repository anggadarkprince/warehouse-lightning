<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportStock;
use App\Models\ReportStockMovement;
use App\Models\WorkOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Get report inbound.
     *
     * @param Request $request
     * @param Report $report
     * @return JsonResponse
     */
    public function inbound(Request $request, Report $report)
    {
        $containerRequest = $request->get('filter') == 'container' ? $request : new Request();
        $containerRequest->merge(['job_type' => WorkOrder::TYPE_UNLOADING]);
        $goodsRequest = $request->get('filter') == 'goods' ? $request : new Request();
        $goodsRequest->merge(['job_type' => WorkOrder::TYPE_UNLOADING]);

        $activityContainers = $report->getActivityContainers($containerRequest);
        $activityGoods = $report->getActivityGoods($goodsRequest);

        $activityContainers = $activityContainers->paginate();
        $activityGoods = $activityGoods->paginate();
        $reportType = 'Inbound';

        return response()->json([
            'data' => compact('activityContainers', 'activityGoods', 'reportType')
        ]);
    }

    /**
     * Get report outbound.
     *
     * @param Request $request
     * @param Report $report
     * @return JsonResponse
     */
    public function outbound(Request $request, Report $report)
    {
        $containerRequest = $request->get('filter') == 'container' ? $request : new Request();
        $containerRequest->merge(['job_type' => WorkOrder::TYPE_LOADING]);
        $goodsRequest = $request->get('filter') == 'goods' ? $request : new Request();
        $goodsRequest->merge(['job_type' => WorkOrder::TYPE_LOADING]);

        $activityContainers = $report->getActivityContainers($containerRequest);
        $activityGoods = $report->getActivityGoods($goodsRequest);

        $activityContainers = $activityContainers->paginate();
        $activityGoods = $activityGoods->paginate();
        $reportType = 'Outbound';

        return response()->json([
            'data' => compact('activityContainers', 'activityGoods', 'reportType')
        ]);
    }

    /**
     * Show stock summary.
     *
     * @param Request $request
     * @param ReportStock $report
     * @return JsonResponse
     */
    public function stockSummary(Request $request, ReportStock $report)
    {
        $containerRequest = $request->get('filter') == 'container' ? $request : new Request();
        $goodsRequest = $request->get('filter') == 'goods' ? $request : new Request();

        $stockContainers = $report->getStockContainers($containerRequest);
        $stockGoods = $report->getStockGoods($goodsRequest);

        return response()->json([
            'data' => [
                'containers' => $stockContainers->paginate(),
                'goods' => $stockGoods->paginate(),
            ]
        ]);
    }

    /**
     * Show stock report movement.
     *
     * @param Request $request
     * @param ReportStockMovement $reportStockMovement
     * @param ReportStock $reportStock
     * @return JsonResponse
     */
    public function stockMovement(Request $request, ReportStockMovement $reportStockMovement, ReportStock $reportStock)
    {
        if ($request->has('booking_id') && $request->filled('booking_id')) {
            $stockContainers = $reportStock->getStockContainers($request->merge(['data' => 'all']));
            $stockGoods = $reportStock->getStockGoods($request->merge(['data' => 'all']));

            $stockMovementContainers = $reportStockMovement->getStockMovementContainer($request);
            $containers = $reportStockMovement->calculateContainerBalance($stockMovementContainers, $stockContainers, $request);

            $stockMovementGoods = $reportStockMovement->getStockMovementGoods($request);
            $goods = $reportStockMovement->calculateGoodsBalance($stockMovementGoods, $stockGoods, $request);
        } else {
            $containers = collect([]);
            $goods = collect([]);
        }

        return response()->json([
            'data' => compact('containers', 'goods')
        ]);
    }
}
