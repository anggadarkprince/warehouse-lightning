<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTallyRequest;
use App\Models\Container;
use App\Models\Goods;
use App\Models\WorkOrder;
use App\Notifications\WorkOrderRejected;
use App\Notifications\WorkOrderValidated;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TallyController extends Controller
{
    /**
     * Show queued job.
     *
     * @param Request $request
     * @return View
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

        return view('tally.index', compact('workOrders'));
    }

    /**
     * Take job data and redirect to form.
     *
     * @param Request $request
     * @param WorkOrder $workOrder
     * @return RedirectResponse
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

            return redirect()->route('tally.proceed-job', ['work_order' => $workOrder->id])->with([
                'status' => 'success',
                'message' => __('Job :job successfully taken, you can release anytime to another user', ['job' => $workOrder->job_number])
            ]);
        });
    }

    /**
     * Continue proceed existing job.
     *
     * @param WorkOrder $workOrder
     * @return View
     * @throws AuthorizationException
     */
    public function proceedJob(WorkOrder $workOrder)
    {
        $this->authorize('take', $workOrder);

        $containers = Container::all();
        $goods = Goods::all();

        return view('tally.proceed', compact('workOrder', 'containers', 'goods'));
    }

    /**
     * Release job data and redirect to index queued job list.
     *
     * @param WorkOrder $workOrder
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function releaseJob(WorkOrder $workOrder)
    {
        $this->authorize('take', $workOrder);

        return DB::transaction(function () use ($workOrder) {
            $workOrder->user_id = null;
            $workOrder->status = WorkOrder::STATUS_QUEUED;
            $workOrder->taken_at = null;
            $workOrder->save();

            $workOrder->statusHistories()->create([
                'status' => WorkOrder::STATUS_QUEUED,
                'description' => 'Job released and ready to take'
            ]);

            return redirect()->route('tally.index')->with([
                'status' => 'warning',
                'message' => __('Job :job successfully released', ['job' => $workOrder->job_number])
            ]);
        });
    }

    /**
     * Save and update work order data.
     *
     * @param SaveTallyRequest $request
     * @param WorkOrder $workOrder
     * @return mixed
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

            return redirect()->route('tally.index')->with([
                "status" => "success",
                "message" => "Work order {$workOrder->job_number} successfully updated"
            ]);
        });
    }

    /**
     * Complete job data and redirect to index list.
     *
     * @param WorkOrder $workOrder
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function completeJob(WorkOrder $workOrder)
    {
        $this->authorize('take', $workOrder);

        return DB::transaction(function () use ($workOrder) {
            $workOrder->status = WorkOrder::STATUS_COMPLETED;
            $workOrder->completed_at = Carbon::now();
            $workOrder->save();

            $workOrder->statusHistories()->create([
                'status' => WorkOrder::STATUS_COMPLETED,
                'description' => 'Job completed and waiting validation'
            ]);

            return redirect()->route('tally.index')->with([
                'status' => 'success',
                'message' => __('Job :job successfully completed, waiting for validation', ['job' => $workOrder->job_number])
            ]);
        });
    }

    /**
     * Validate job data and redirect to index list.
     *
     * @param Request $request
     * @param WorkOrder $workOrder
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function validateJob(Request $request, WorkOrder $workOrder)
    {
        $this->authorize('validate', $workOrder);

        $message = ucfirst($request->input('message'));
        if ($request->input('refuse', 0)) {
            $workOrder->update(['status' => WorkOrder::STATUS_REJECTED]);

            $workOrder->statusHistories()->create([
                'status' => WorkOrder::STATUS_REJECTED,
                'description' => $message ?: 'Job is rejected'
            ]);

            $workOrder->user->notify((new WorkOrderRejected($workOrder, $message)));

            return redirect()->route('tally.index')->with([
                'status' => 'success',
                'message' => __('Job :job successfully validated', ['job' => $workOrder->job_number])
            ]);
        } else {
            $workOrder->update(['status' => WorkOrder::STATUS_VALIDATED]);

            $workOrder->statusHistories()->create([
                'status' => WorkOrder::STATUS_VALIDATED,
                'description' => $message ?: 'Job is completed'
            ]);

            $workOrder->user->notify(
                (new WorkOrderValidated($workOrder, $message))
                    ->delay(now()->addSeconds(15))
            );

            return redirect()->route('tally.index')->with([
                'status' => 'danger',
                'message' => __('Job :job successfully rejected', ['job' => $workOrder->job_number])
            ]);
        }
    }
}
