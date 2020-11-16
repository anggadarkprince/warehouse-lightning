<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeStockGoods extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'booking_id',
        'goods_id',
        'unit_quantity',
        'package_quantity',
        'weight',
        'gross_weight',
        'description',
        'revision_unit_quantity',
        'revision_package_quantity',
        'revision_weight',
        'revision_gross_weight',
        'revision_description',
    ];

    /**
     * Get the take stock of the goods.
     */
    public function takeStock()
    {
        return $this->belongsTo(TakeStock::class);
    }

    /**
     * Get the goods of the take stock.
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }
}
