<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveTallyRequest;
use App\Models\Container;
use App\Models\Goods;
use App\Models\WorkOrder;
use App\Notifications\WorkOrderRejected;
use App\Notifications\WorkOrderValidated;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TallyController extends Controller
{
    /**
     * Show queued job.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view-take', WorkOrder::class);

        $workOrders = WorkOrder::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method', 'asc'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'))
            ->status(WorkOrder::STATUS_OUTSTANDING)
            ->get();

        return response()->json([
            'data' => $workOrders
        ]);
    }

    /**
     * Take job data and redirect to form.
     *
     * @param Request $request
     * @param WorkOrder $workOrder
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function takeJob(Request $request, WorkOrder $workOrder)
    {
        $this->authorize('view-take', WorkOrder::class);

        return DB::transaction(function () use ($request, $workOrder) {
            $workOrder->user_id = $request->user()->id;
            $workOrder->status = WorkOrder::STATUS_TAKEN;
            $workOrder->taken_at = Carbon::now();
            $workOrder->save();

            $workOrder->statusHistories()->create([
                'status' => WorkOrder::STATUS_TAKEN,
                'description' => 'Job taken by ' . $workOrder->user->name
            ]);

            return response()->json([
                "status" => "success",
                'data' => $workOrder,
                "message" => __("Job :number successfully taken, you can release anytime to another user", [
                    'number' => $workOrder->job_number
                ])
            ]);
        });
    }

    /**
     * Continue proceed existing job.
     *
     * @param WorkOrder $workOrder
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function proceedJob(WorkOrder $workOrder)
    {
        $this->authorize('take', $workOrder);

        return response()->json([
            'data' => $workOrder->load([
                'workOrderContainers',
                'workOrderGoods'
            ]),
        ]);
    }

    /**
     * Release job data and redirect to index queued job list.
     *
     * @param WorkOrder $workOrder
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function releaseJob(WorkOrder $workOrder)
    {
        $this->authorize('take', $workOrder);

        return DB::transaction(function () use ($workOrder) {
            $workOrder->update([
                'user_id' => null,
                'status' => WorkOrder::STATUS_QUEUED,
                'taken_at' => null,
            ]);

            $workOrder->statusHistories()->create([
                'status' => WorkOrder::STATUS_QUEUED,
                'description' => 'Job released and ready to take'
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $workOrder,
                'message' => __('Job :number successfully released', [
                    'number' => $workOrder->job_number
                ])
            ]);
        });
    }

    /**
     * Save and update work order data.
     *
     * @param SaveTallyRequest $request
     * @param WorkOrder $workOrder
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function saveJob(SaveTallyRequest $request, WorkOrder $workOrder)
    {
        $this->authorize('take', $workOrder);

        return DB::transaction(function () use ($request, $workOrder) {
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

            return response()->json([
                'status' => 'success',
                'data' => $workOrder,
                'message' => __('Job :number successfully saved', [
                    'number' => $workOrder->job_number
                ])
            ]);
        });
    }

    /**
     * Complete job data and redirect to index list.
     *
     * @param WorkOrder $workOrder
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function completeJob(WorkOrder $workOrder)
    {
        $this->authorize('take', $workOrder);

        return DB::transaction(function () use ($workOrder) {
            $workOrder->update([
                'status' => WorkOrder::STATUS_COMPLETED,
                'completed_at' => Carbon::now()
            ]);

            $workOrder->statusHistories()->create([
                'status' => WorkOrder::STATUS_COMPLETED,
                'description' => 'Job completed and waiting for validation'
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $workOrder,
                'message' => __('Job :number successfully completed, waiting for validation', [
                    'number' => $workOrder->job_number
                ])
            ]);
        });
    }

    /**
     * Validate job data and redirect to index list.
     *
     * @param Request $request
     * @param WorkOrder $workOrder
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function validateJob(Request $request, WorkOrder $workOrder)
    {
        $this->authorize('validate', $workOrder);

        $message = ucfirst($request->input('message'));
        $workOrder->update(['status' => WorkOrder::STATUS_VALIDATED]);

        $workOrder->statusHistories()->create([
            'status' => WorkOrder::STATUS_VALIDATED,
            'description' => $message ?: 'Job is validated'
        ]);

        $workOrder->user->notify(new WorkOrderValidated($workOrder, $message));

        return response()->json([
            'status' => 'success',
            'data' => $workOrder,
            'message' => __('Job :number successfully validated', [
                'number' => $workOrder->job_number
            ])
        ]);
    }

    /**
     * Validate job data and redirect to index list.
     *
     * @param Request $request
     * @param WorkOrder $workOrder
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function rejectJob(Request $request, WorkOrder $workOrder)
    {
        $this->authorize('validate', $workOrder);

        $message = ucfirst($request->input('message'));
        $workOrder->update(['status' => WorkOrder::STATUS_REJECTED]);

        $workOrder->statusHistories()->create([
            'status' => WorkOrder::STATUS_REJECTED,
            'description' => $message ?: 'Job is rejected'
        ]);

        $workOrder->user->notify(new WorkOrderRejected($workOrder, $message));

        return response()->json([
            'status' => 'success',
            'data' => $workOrder,
            'message' => __('Job :number successfully rejected', [
                'number' => $workOrder->job_number
            ])
        ]);
    }
}
