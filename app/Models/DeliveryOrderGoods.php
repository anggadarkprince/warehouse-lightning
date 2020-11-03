<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderGoods extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['goods_id', 'unit_quantity', 'package_quantity', 'weight', 'gross_weight', 'description'];

    /**
     * Get the delivery order of the goods.
     */
    public function deliveryOrder()
    {
        return $this->belongsTo(DeliveryOrder::class);
    }

    /**
     * Get the goods of the delivery order.
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }
}
