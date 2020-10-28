<?php

namespace App\Models;

use App\Traits\Search\BasicFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use BasicFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['customer_id', 'booking_type_id', 'upload_title', 'status', 'description'];

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
            $model->upload_number = $model->getUploadNumber();
        });
    }

    /**
     * Get the customer of the upload.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the booking type of the upload.
     */
    public function bookingType()
    {
        return $this->belongsTo(BookingType::class);
    }

    /**
     * Get the booking of the upload.
     */
    public function booking()
    {
        return $this->hasOne(Booking::class);
    }

    /**
     * Get the documents of the upload.
     */
    public function uploadDocuments()
    {
        return $this->hasMany(UploadDocument::class);
    }

    /**
     * Get the document files of the upload.
     */
    public function uploadDocumentFiles()
    {
        return $this->hasManyThrough(UploadDocumentFile::class, UploadDocument::class);
    }

    /**
     * Scope a query to filter by validated upload.
     *
     * @param Builder $query
     * @param null $exceptId
     * @return Builder
     */
    public function scopeValidated(Builder $query, $exceptId = null)
    {
        $baseQuery = $query->where('status', self::STATUS_VALIDATED);

        if (!empty($exceptId)) {
            $baseQuery->orWhere('id', $exceptId);
        }

        return $baseQuery;
    }

    /**
     * Get next upload number.
     *
     * @return string
     */
    public function getUploadNumber()
    {
        $query = $this->newQuery()
            ->selectRaw("CAST(RIGHT(upload_number, 6) AS UNSIGNED) + 1 AS order_number")
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->orderBy('upload_number', 'desc')
            ->take('1');

        $orderPad = '000001';
        if ($query->count()) {
            $orderPad = str_pad($query->first()->order_number, 6, '0', STR_PAD_LEFT);
        }
        return 'UP-' . date('ym') . $orderPad;
    }
}
