<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingGoods extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['goods_id', 'unit_quantity', 'package_quantity', 'weight', 'gross_weight', 'description'];

    /**
     * Get the booking of the goods.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the goods of the booking goods.
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }
}
