<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingContainer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['container_id', 'is_empty', 'seal', 'description'];

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
