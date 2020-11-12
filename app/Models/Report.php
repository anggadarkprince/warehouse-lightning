<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Report extends Model
{
    /**
     * Get inbound container report.
     *
     * @param Request $request
     * @return Builder
     */
    public function getActivityContainers(Request $request)
    {
        return WorkOrderContainer::with('workOrder.booking.customer')
            ->with('workOrder.booking.bookingType')
            ->with('container')
            ->whereHas('workOrder', function (Builder $query) use ($request) {
                $query->where('status', WorkOrder::STATUS_VALIDATED);
                if ($request->filled('job_type')) {
                    $query->where('job_type', $request->get('job_type'));
                }
            })
            ->where(function (Builder $query) use ($request) {
                $query->orWhere('work_order_containers.description', 'LIKE', '%' . $request->get('q') . '%');

                $query->orWhereHas('workOrder.booking', function (Builder $query) use ($request) {
                    $query->where('reference_number', 'LIKE', '%' . $request->get('q') . '%');
                    $query->orWhere('booking_number', 'LIKE', '%' . $request->get('q') . '%');
                });

                $query->orWhereHas('workOrder.booking.bookingType', function (Builder $query) use ($request) {
                    $query->orWhere('booking_name', 'LIKE', '%' . $request->get('q') . '%');
                });

                $query->orWhereHas('workOrder.booking.customer', function (Builder $query) use ($request) {
                    $query->where('customer_name', 'LIKE', '%' . $request->get('q') . '%');
                });

                $query->orWhereHas('workOrder', function (Builder $query) use ($request) {
                    $query->where('job_number', 'LIKE', '%' . $request->get('q') . '%');
                });

                $query->orWhereHas('container', function (Builder $query) use ($request) {
                    $query->where('container_number', 'LIKE', '%' . $request->get('q') . '%');
                    $query->orWhere('container_type', 'LIKE', '%' . $request->get('q') . '%');
                    $query->orWhere('container_size', 'LIKE', '%' . $request->get('q') . '%');
                });
            });
    }

    /**
     * Get inbound goods report.
     *
     * @param Request $request
     * @return Builder
     */
    public function getActivityGoods(Request $request)
    {
        return WorkOrderGoods::with('workOrder.booking.customer')
            ->with('workOrder.booking.bookingType')
            ->with('goods')
            ->whereHas('workOrder', function (Builder $query) use ($request) {
                $query->where('status', WorkOrder::STATUS_VALIDATED);
                if ($request->filled('job_type')) {
                    $query->where('job_type', $request->get('job_type'));
                }
            })
            ->where(function (Builder $query) use ($request) {
                $query->orWhere('work_order_goods.description', 'LIKE', '%' . $request->get('q') . '%');

                $query->orWhereHas('workOrder.booking', function (Builder $query) use ($request) {
                    $query->where('reference_number', 'LIKE', '%' . $request->get('q') . '%');
                    $query->orWhere('booking_number', 'LIKE', '%' . $request->get('q') . '%');
                });

                $query->orWhereHas('workOrder.booking.bookingType', function (Builder $query) use ($request) {
                    $query->orWhere('booking_name', 'LIKE', '%' . $request->get('q') . '%');
                });

                $query->orWhereHas('workOrder.booking.customer', function (Builder $query) use ($request) {
                    $query->where('customer_name', 'LIKE', '%' . $request->get('q') . '%');
                });

                $query->orWhereHas('workOrder', function (Builder $query) use ($request) {
                    $query->where('job_number', 'LIKE', '%' . $request->get('q') . '%');
                });

                $query->orWhereHas('goods', function (Builder $query) use ($request) {
                    $query->where('item_number', 'LIKE', '%' . $request->get('q') . '%');
                    $query->orWhere('item_name', 'LIKE', '%' . $request->get('q') . '%');
                    $query->orWhere('unit_name', 'LIKE', '%' . $request->get('q') . '%');
                    $query->orWhere('package_name', 'LIKE', '%' . $request->get('q') . '%');
                });
            });
    }
}
