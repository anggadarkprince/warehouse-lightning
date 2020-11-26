<?php

namespace App\Models;

use App\Contracts\Numerable\HasOrderNumber;
use App\Contracts\Statusable\HasStatusLabel;
use App\Traits\Search\BasicFilter;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Scout\Searchable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class WorkOrder extends Model implements HasOrderNumber, HasStatusLabel
{
    use SoftDeletes, BasicFilter, Searchable;

    const TYPE_UNLOADING = "UNLOADING";
    const TYPE_STRIPPING_CONTAINER = "STRIPPING CONTAINER";
    const TYPE_RETURN_EMPTY_CONTAINER = "RETURN EMPTY CONTAINER";
    const TYPE_REPACKING_GOODS = "REPACKING GOODS";
    const TYPE_UNPACKING_GOODS = "UNPACKING GOODS";
    const TYPE_LOADING = "LOADING";
    const TYPE_TAKE_STOCK = "TAKE STOCK";

    const STATUS_QUEUED = "QUEUED";
    const STATUS_TAKEN = "TAKEN";
    const STATUS_REJECTED = "REJECTED";
    const STATUS_COMPLETED = "COMPLETED";
    const STATUS_VALIDATED = "VALIDATED";
    const STATUS_OUTSTANDING = "OUTSTANDING";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['booking_id', 'user_id', 'job_type', 'description', 'status'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'taken_at' => 'datetime',
        'completed_at' => 'datetime',
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
            $model->job_number = $model->getOrderNumber();
        });
    }

    /**
     * Get the booking of the work order.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the user of the work order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the containers of the work order.
     */
    public function workOrderContainers()
    {
        return $this->hasMany(WorkOrderContainer::class);
    }

    /**
     * Get the goods of the work order.
     */
    public function workOrderGoods()
    {
        return $this->hasMany(WorkOrderGoods::class);
    }

    /**
     * Get all of the upload's statuses.
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
            ->selectRaw("CAST(RIGHT(job_number, 6) AS UNSIGNED) + 1 AS order_number")
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->orderBy('created_at', 'desc')
            ->take('1');

        $orderPad = '000001';
        if ($query->count()) {
            $orderPad = str_pad($query->first()->order_number, 6, '0', STR_PAD_LEFT);
        }

        $prefix = 'JOB';
        switch ($this->job_type) {
            case self::TYPE_UNLOADING:
                $prefix = 'UL';
                break;
            case self::TYPE_STRIPPING_CONTAINER:
                $prefix = 'SP';
                break;
            case self::TYPE_RETURN_EMPTY_CONTAINER:
                $prefix = 'EC';
                break;
            case self::TYPE_UNPACKING_GOODS:
                $prefix = 'UP';
                break;
            case self::TYPE_REPACKING_GOODS:
                $prefix = 'RP';
                break;
            case self::TYPE_LOADING:
                $prefix = 'LO';
                break;
            case self::TYPE_TAKE_STOCK:
                $prefix = 'TS';
                break;
        }

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
            $query->orWhereHas('user', function (Builder $query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            });
        });
    }

    /**
     * Scope a query to only include job that match the status.
     *
     * @param Builder $query
     * @param $status
     * @return Builder
     */
    public function scopeStatus(Builder $query, $status)
    {
        if($status == self::STATUS_OUTSTANDING) {
            return $query->where('status', '!=', self::STATUS_VALIDATED);
        }
        return $query->where('status', $status);
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
            'job_number' => $this->job_number,
            'job_type' => $this->job_type,
            'assigned_to' => $this->user->name,
            'booking_name' => $this->booking->bookingType->booking_name,
            'booking_number' => $this->booking->booking_number,
            'reference_number' => $this->booking->reference_number,
            'customer' => $this->booking->customer->customer_name,
        ];
    }

    /**
     * Get pdf from current data.
     *
     * @param bool $stream
     * @return BinaryFileResponse|StreamedResponse
     */
    public function getPdf($stream = true)
    {
        $pdf = app('dompdf.wrapper')->loadView('work-orders.print', ['workOrder' => $this]);

        if ($stream) {
            return $pdf->stream('work-order.pdf');
        }

        return $pdf->download('work-order.pdf');
    }

    /**
     * Return status label of model.
     *
     * @param null $status
     * @return mixed
     */
    public function getStatusClass($status = null)
    {
        switch ($status ?: $this->status) {
            case self::STATUS_QUEUED:
            default:
                return 'bg-gray-200';
            case self::STATUS_TAKEN:
                return 'text-white bg-orange-500';
            case self::STATUS_REJECTED:
                return 'text-white bg-red-500';
            case self::STATUS_COMPLETED:
                return 'text-white bg-blue-500';
            case self::STATUS_VALIDATED:
                return 'text-white bg-green-500';
        }
    }
}
