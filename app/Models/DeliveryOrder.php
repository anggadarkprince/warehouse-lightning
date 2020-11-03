<?php

namespace App\Models;

use App\Contracts\Numerable\HasOrderNumber;
use App\Traits\Search\BasicFilter;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
     * Get the containers of the delivery order.
     */
    public function deliveryOrderContainers()
    {
        return $this->hasMany(DeliveryOrderContainer::class);
    }

    /**
     * Get the goods of the delivery order.
     */
    public function deliveryOrderGoods()
    {
        return $this->hasMany(DeliveryOrderGoods::class);
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

    /**
     * Scope a query to only include group that match the query.
     *
     * @param Builder $query
     * @param string $q
     * @return Builder
     */
    public function scopeQ(Builder $query, $q = '')
    {
        if (empty($q)) return $query;

        $columns = Schema::getColumnListing($this->getTable());
        return $query->where(function (Builder $query) use ($q, $columns) {
            foreach ($columns as $column) {
                if (in_array(DB::getSchemaBuilder()->getColumnType($this->getTable(), $column), ['date', 'datetime'])) {
                    try {
                        $q = Carbon::parse($q)->format('Y-m-d');
                    } catch (InvalidFormatException $e) {
                    }
                }
                $query->orWhere($column, 'LIKE', '%' . trim($q) . '%');
            }
            $query->orWhereHas('booking.bookingType', function (Builder $query) use ($q) {
                $query->where('booking_types.type', 'LIKE', '%' . $q . '%');
                $query->orWhere('booking_name', 'LIKE', '%' . $q . '%');
            });
            $query->orWhereHas('booking', function (Builder $query) use ($q) {
                $query->where('reference_number', 'LIKE', '%' . $q . '%');
                $query->orWhere('booking_number', 'LIKE', '%' . $q . '%');
            });
            $query->orWhereHas('booking.customer', function (Builder $query) use ($q) {
                $query->where('customer_name', 'LIKE', '%' . $q . '%');
            });
        });
    }

    /**
     * Scope a query to sort group by specific column.
     *
     * @param Builder $query
     * @param $sortBy
     * @param string $sortMethod
     * @return Builder
     */
    public function scopeSort(Builder $query, $sortBy = 'created_at', $sortMethod = 'desc')
    {
        if (empty($sortBy)) $sortBy = 'created_at';
        if (empty($sortMethod)) $sortMethod = 'desc';

        if (in_array($sortBy, ['reference_number', 'booking_number', 'customer_name'])) {
            $query->join('bookings', 'bookings.id', '=', 'delivery_orders.booking_id');
        }
        if (in_array($sortBy, ['customer_name'])) {
            $query->join('customers', 'customers.id', '=', 'bookings.customer_id');
        }

        return $query->orderBy($sortBy, $sortMethod);
    }

    /**
     * Get pdf from current data.
     *
     * @param bool $stream
     * @return
     */
    public function getPdf($stream = true)
    {
        $pdf = app('dompdf.wrapper')->loadView('delivery-orders.print', ['deliveryOrder' => $this]);

        if ($stream) {
            return $pdf->stream('invoice.pdf');
        }

        return $pdf->download('invoice.pdf');
    }
}
