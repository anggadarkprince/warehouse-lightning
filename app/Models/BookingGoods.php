<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingGoods extends Model
{
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
