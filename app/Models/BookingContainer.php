<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingContainer extends Model
{
    /**
     * Get the booking of the container.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the container of the booking containers.
     */
    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
