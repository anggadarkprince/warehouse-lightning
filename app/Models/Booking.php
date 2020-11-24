<?php

namespace App\Models;

use App\Contracts\Numerable\HasOrderNumber;
use App\Traits\Search\BasicFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Laravel\Scout\Searchable;

class Booking extends Model implements HasOrderNumber
{
    use BasicFilter, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'upload_id',
        'customer_id',
        'booking_type_id',
        'booking_number',
        'reference_number',
        'supplier_name',
        'owner_name',
        'shipper_name',
        'voy_flight',
        'arrival_date',
        'tps',
        'total_cif',
        'total_gross_weight',
        'total_weight',
        'xml_file',
        'status',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'arrival_date' => 'date',
    ];

    const STATUS_DRAFT = 'DRAFT';
    const STATUS_VALIDATED = 'VALIDATED';

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->booking_number = $model->getOrderNumber();
        });
    }

    /**
     * Set arrival date.
     *
     * @param $cif
     */
    public function setTotalCifAttribute($cif)
    {
        $this->attributes['total_cif'] = extract_number($cif);
    }

    /**
     * Set gross weight date.
     *
     * @param $weight
     */
    public function setTotalGrossWeightAttribute($weight)
    {
        $this->attributes['total_gross_weight'] = extract_number($weight);
    }

    /**
     * Set net weight date.
     *
     * @param $weight
     */
    public function setTotalWeightAttribute($weight)
    {
        $this->attributes['total_weight'] = extract_number($weight);
    }

    /**
     * Scope a query to filter by validated booking.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeValidated(Builder $query)
    {
        return $query->where('status', self::STATUS_VALIDATED);
    }

    /**
     * Scope a query to filter by type booking.
     *
     * @param Builder $query
     * @param $type
     * @return Builder
     */
    public function scopeType(Builder $query, $type)
    {
        return $query->orWhereHas('bookingType', function (Builder $query) use ($type) {
            $query->where('booking_types.type', $type);
        });
    }

    /**
     * Get the customer of the booking.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the booking type of the booking.
     */
    public function bookingType()
    {
        return $this->belongsTo(BookingType::class);
    }

    /**
     * Get the upload of the booking.
     */
    public function upload()
    {
        return $this->belongsTo(Upload::class);
    }

    /**
     * Get the containers of the booking.
     */
    public function bookingContainers()
    {
        return $this->hasMany(BookingContainer::class);
    }

    /**
     * Get the goods of the booking.
     */
    public function bookingGoods()
    {
        return $this->hasMany(BookingGoods::class);
    }

    /**
     * Get the delivery orders of the booking.
     */
    public function deliveryOrders()
    {
        return $this->hasMany(DeliveryOrder::class);
    }

    /**
     * Get the work orders of the booking.
     */
    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }

    /**
     * Get all of the booking's statuses.
     */
    public function statusHistories()
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }

    /**
     * Return generated order number or model.
     *
     * @return mixed
     */
    public function getOrderNumber()
    {
        $query = $this->newQuery()
            ->selectRaw("CAST(RIGHT(booking_number, 6) AS UNSIGNED) + 1 AS order_number")
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->orderBy('booking_number', 'desc')
            ->take('1');

        $orderPad = '000001';
        if ($query->count()) {
            $orderPad = str_pad($query->first()->order_number, 6, '0', STR_PAD_LEFT);
        }

        $prefix = empty($this->bookingType) ? 'B' : $this->bookingType->type == 'INBOUND' ? 'BI' : 'BO';

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
        if (empty($q)) {
            return $query;
        }
        $columns = Schema::getColumnListing($this->getTable());
        return $query->where(function (Builder $query) use ($q, $columns) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', '%' . trim($q) . '%');
            }
            $query->orWhereHas('bookingType', function (Builder $query) use ($q) {
                $query->where('booking_types.type', 'LIKE', '%' . $q . '%');
                $query->orWhere('booking_name', 'LIKE', '%' . $q . '%');
            });
            $query->orWhereHas('customer', function (Builder $query) use ($q) {
                $query->where('customer_name', 'LIKE', '%' . $q . '%');
            });
            $query->orWhereHas('upload', function (Builder $query) use ($q) {
                $query->where('upload_number', 'LIKE', '%' . $q . '%');
            });
        });
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'booking_number' => $this->booking_number,
            'reference_number' => $this->reference_number,
            'supplier_name' => $this->supplier_name,
            'owner_name' => $this->owner_name,
            'shipper_name' => $this->shipper_name,
            'upload_number' => $this->upload->upload_number,
            'booking_name' => $this->bookingType->booking_name,
            'type' => $this->bookingType->type,
            'customer' => $this->customer->customer_name,
        ];
    }
}
