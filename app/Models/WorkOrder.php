<?php

namespace App\Models;

use App\Contracts\Numerable\HasOrderNumber;
use App\Traits\Search\BasicFilter;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model implements HasOrderNumber
{
    use BasicFilter;

    const TYPE_UNLOADING = "UNLOADING";
    const TYPE_STRIPPING_CONTAINER = "CONTAINER_STRIPPING";
    const TYPE_RETURN_EMPTY_CONTAINER = "RETURN_EMPTY_CONTAINER";
    const TYPE_REPACKING_GOODS = "REPACKING_GOODS";
    const TYPE_UNPACKING_GOODS = "UNPACKING_GOODS";
    const TYPE_LOADING = "LOADING";


    /**
     * Get the booking of the work order.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the containers of the work order.
     */
    public function workOrderContainers()
    {
        return $this->hasMany(WorkOrderContainer::class);
    }

    /**
     * Get the goods of the work order.
     */
    public function workOrderGoods()
    {
        return $this->hasMany(WorkOrderGoods::class);
    }

    /**
     * Return generated order number or model.
     *
     * @return mixed
     */
    public function getOrderNumber()
    {
        $query = $this->newQuery()
            ->selectRaw("CAST(RIGHT(job_number, 6) AS UNSIGNED) + 1 AS order_number")
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->orderBy('job_number', 'desc')
            ->take('1');

        $orderPad = '000001';
        if ($query->count()) {
            $orderPad = str_pad($query->first()->order_number, 6, '0', STR_PAD_LEFT);
        }

        $prefix = 'JOB';
        switch ($this->job_type) {
            case self::TYPE_UNLOADING:
                $prefix = 'UL';
                break;
            case self::TYPE_STRIPPING_CONTAINER:
                $prefix = 'SP';
                break;
            case self::TYPE_RETURN_EMPTY_CONTAINER:
                $prefix = 'EC';
                break;
            case self::TYPE_UNPACKING_GOODS:
                $prefix = 'UP';
                break;
            case self::TYPE_REPACKING_GOODS:
                $prefix = 'RP';
                break;
            case self::TYPE_LOADING:
                $prefix = 'LO';
                break;
        }

        return $prefix . '-' . date('ym') . $orderPad;
    }
}
