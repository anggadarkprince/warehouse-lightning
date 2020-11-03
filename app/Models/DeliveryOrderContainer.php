<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderContainer extends Model
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
    public function deliveryOrder()
    {
        return $this->belongsTo(DeliveryOrder::class);
    }

    /**
     * Get the container of the delivery order containers.
     */
    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
