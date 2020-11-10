<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $workOrder->user_id = $request->user()->id;
        $workOrder->status = WorkOrder::STATUS_TAKEN;
        $workOrder->taken_at = Carbon::now();
        $workOrder->save();

        return redirect()->route('tally.proceed-job', ['work_order' => $workOrder->id])->with([
            'status' => 'success',
            'message' => __('Job :job successfully taken, you can release anytime to another user', ['job' => $workOrder->job_number])
        ]);
    }

    /**
     * Continue proceed existing job.
     *
     * @param WorkOrder $workOrder
     * @return View
     */
    public function proceedJob(WorkOrder $workOrder)
    {
        return view('tally.proceed', compact('workOrder'));
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

        $workOrder->user_id = null;
        $workOrder->status = WorkOrder::STATUS_QUEUED;
        $workOrder->taken_at = null;
        $workOrder->save();

        return redirect()->route('tally.index')->with([
            'status' => 'warning',
            'message' => __('Job :job successfully released', ['job' => $workOrder->job_number])
        ]);
    }
}
