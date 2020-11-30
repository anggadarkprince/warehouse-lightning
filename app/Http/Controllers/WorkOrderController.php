<?php

namespace App\Http\Controllers;

use App\Events\JobAssignedEvent;
use App\Http\Requests\SaveWorkOrderRequest;
use App\Models\Booking;
use App\Models\DeliveryOrder;
use App\Models\User;
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

class WorkOrderController extends Controller
{
    /**
     * WorkOrderController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(WorkOrder::class);
    }

    /**
     * Display the specified work order.
     *
     * @param WorkOrder $workOrder
     * @return View
     */
    public function show(WorkOrder $workOrder)
    {
        return view('work-orders.show', compact('workOrder'));
    }

    /**
     * Show the form for creating a new delivery order.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request)
    {
        $selectedBooking = Booking::find($request->get('booking_id'));
        $bookings = Booking::validated()->type('INBOUND')->get();
        $users = User::all();

        return view('work-orders.create', compact('bookings', 'users', 'selectedBooking'));
    }

    /**
     * Print work order.
     *
     * @param WorkOrder $workOrder
     * @return BinaryFileResponse|StreamedResponse
     * @throws AuthorizationException
     */
    public function printWorkOrder(WorkOrder $workOrder)
    {
        $this->authorize('view', $workOrder);

        return $workOrder->getPdf();
    }

    /**
     * Store a newly created work order in storage.
     *
     * @param SaveWorkOrderRequest $request
     * @return Response|RedirectResponse
     */
    public function store(SaveWorkOrderRequest $request)
    {
        return DB::transaction(function () use ($request) {
            if (empty($request->has('delivery_order_id'))) {
                $workOrder = WorkOrder::create($request->input());
            } else {
                $request->merge(['job_type' => WorkOrder::TYPE_UNLOADING]);
                $deliveryOrder = DeliveryOrder::find($request->input('delivery_order_id'));
                $workOrder = $deliveryOrder->booking->workOrders()->create($request->only(['user_id', 'job_type', 'description']));
            }

            $workOrder->workOrderContainers()->createMany($request->input('containers', []));
            $workOrder->workOrderGoods()->createMany($request->input('goods', []));

            $workOrder->statusHistories()->create([
                'status' => WorkOrder::STATUS_QUEUED,
                'description' => 'Initial job creation'
            ]);

            $request->whenHas('user_id', function ($userId) use ($workOrder) {
                if (!empty($userId)) {
                    event(new JobAssignedEvent($workOrder));
                }
            });

            return redirect()->route('gate.index')->with([
                "status" => "success",
                "message" => "Work order {$workOrder->job_number} successfully created"
            ]);
        });
    }

    /**
     * Show the form for editing the specified work order.
     *
     * @param WorkOrder $workOrder
     * @return View
     */
    public function edit(WorkOrder $workOrder)
    {
        $bookings = Booking::validated()->orWhere('id', $workOrder->booking_id)->get();
        $users = User::all();

        return view('work-orders.edit', compact('workOrder', 'bookings', 'users'));
    }

    /**
     * Update the specified delivery order in storage.
     *
     * @param Request $request
     * @param WorkOrder $workOrder
     * @return RedirectResponse
     */
    public function update(Request $request, WorkOrder $workOrder)
    {
        DB::transaction(function () use ($request, $workOrder) {
            $workOrder->fill($request->input())->save();

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
        });

        if (data_get($workOrder->getChanges(), 'user_id')) {
            event(new JobAssignedEvent($workOrder));
        }

        return redirect()->route('gate.index')->with([
            "status" => "success",
            "message" => "Work order {$workOrder->work_number} successfully updated"
        ]);
    }

    /**
     * Remove the specified work order from storage.
     *
     * @param WorkOrder $workOrder
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(WorkOrder $workOrder)
    {
        $workOrder->delete();

        return redirect()->back()->with([
            "status" => "warning",
            "message" => "Work order {$workOrder->work_number} successfully deleted"
        ]);
    }
}
