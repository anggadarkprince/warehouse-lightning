<?php

namespace App\Models;

use App\Contracts\Numerable\HasOrderNumber;
use App\Contracts\Statusable\HasStatusLabel;
use App\Traits\Search\BasicFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model implements HasStatusLabel, HasOrderNumber
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
     * Get the customer of the upload.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    /**
     * Get the booking type of the upload.
     */
    public function bookingType()
    {
        return $this->belongsTo(BookingType::class)->withTrashed();
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
     * Get all of the upload's statuses.
     */
    public function statusHistories()
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
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
     * Return status label of model.
     *
     * @param null $status
     * @return mixed
     */
    public function getStatusClass($status = null)
    {
        switch ($status ?: $this->status) {
            case self::STATUS_DRAFT:
            default:
                return 'bg-gray-200';
            case self::STATUS_VALIDATED:
                return 'text-white bg-green-500';
        }
    }

    /**
     * Return generated order number or model.
     *
     * @return mixed
     */
    public function getOrderNumber()
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

    /**
     * Move uploaded temp file into proper folder and return destination src and file name.
     *
     * @param $file
     * @return array
     */
    public function moveUploadedFile($file)
    {
        $moveFileTo = 'documents/' . date('Y/m/') . basename($file['src']);
        if (Storage::exists($moveFileTo)) {
            Storage::delete($moveFileTo);
        }
        if (Storage::move($file['src'], $moveFileTo)) {
            $file['src'] = $moveFileTo;
            if (empty($file['file_name'])) {
                $file['file_name'] = basename($file['src']);
            }
        } else {
            abort(500, __('Move uploaded file failed'));
        }

        return [
            'src' => $file['src'],
            'file_name' => $file['file_name'],
        ];
    }
}
