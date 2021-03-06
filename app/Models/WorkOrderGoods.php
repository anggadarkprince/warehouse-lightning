<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrderGoods extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['goods_id', 'unit_quantity', 'package_quantity', 'weight', 'gross_weight', 'description'];

    /**
     * Get the work order of the goods.
     */
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }

    /**
     * Get the goods of the work order.
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }

    /**
     * Get all of the goods reference.
     */
    public function references()
    {
        return $this->morphMany(WorkOrderReference::class, 'reference');
    }

    /**
     * Get all of the goods source.
     */
    public function sources()
    {
        return $this->morphMany(WorkOrderReference::class, 'source');
    }
}
