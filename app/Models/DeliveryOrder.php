<?php

namespace App\Models;

use App\Contracts\Numerable\HasOrderNumber;
use App\Traits\Search\BasicFilter;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model implements HasOrderNumber
{
    use BasicFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'booking_id', 'type', 'destination', 'destination_address', 'delivery_date', 'driver_name',
        'vehicle_name', 'vehicle_type', 'vehicle_plat_number', 'description'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'delivery_date' => 'date',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->delivery_number = $model->getOrderNumber();
        });
    }

    /**
     * Get the booking of the delivery order.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Return generated order number or model.
     *
     * @return mixed
     */
    public function getOrderNumber()
    {
        $query = $this->newQuery()
            ->selectRaw("CAST(RIGHT(delivery_number, 6) AS UNSIGNED) + 1 AS order_number")
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->orderBy('delivery_number', 'desc')
            ->take('1');

        $orderPad = '000001';
        if ($query->count()) {
            $orderPad = str_pad($query->first()->order_number, 6, '0', STR_PAD_LEFT);
        }

        $prefix = empty($this->type) ? 'D' : $this->type == 'INBOUND' ? 'DI' : 'DO';

        return $prefix . '-' . date('ym') . $orderPad;
    }
}
