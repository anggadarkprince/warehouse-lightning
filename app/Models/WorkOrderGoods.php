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
}
