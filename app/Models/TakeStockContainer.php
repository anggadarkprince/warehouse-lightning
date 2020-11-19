<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TakeStockContainer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'booking_id',
        'container_id',
        'is_empty',
        'seal',
        'description',
        'quantity',
        'revision_quantity',
        'revision_description',
    ];

    /**
     * Get the take stock of the container.
     */
    public function takeStock()
    {
        return $this->belongsTo(TakeStock::class);
    }

    /**
     * Get the take stock of the booking.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the container of the take stock containers.
     */
    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
