<?php

namespace App\Models;

use App\Contracts\Numerable\HasOrderNumber;
use App\Traits\Search\BasicFilter;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TakeStock extends Model implements HasOrderNumber
{
    use BasicFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['status', 'description'];

    const STATUS_PENDING = 'PENDING';
    const STATUS_IN_PROCESS = 'IN PROCESS';
    const STATUS_SUBMITTED = 'SUBMITTED';
    const STATUS_REJECTED = 'REJECTED';
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
            $model->take_stock_number = $model->getOrderNumber();
        });
    }

    /**
     * Get the containers of the take stock.
     */
    public function takeStockContainers()
    {
        return $this->hasMany(TakeStockContainer::class);
    }

    /**
     * Get the goods of the take stock.
     */
    public function takeStockGoods()
    {
        return $this->hasMany(TakeStockGoods::class);
    }

    /**
     * Get all of the take stock statuses.
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
            ->selectRaw("CAST(RIGHT(take_stock_number, 6) AS UNSIGNED) + 1 AS order_number")
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->orderBy('created_at', 'desc')
            ->take('1');

        $orderPad = '000001';
        if ($query->count()) {
            $orderPad = str_pad($query->first()->order_number, 6, '0', STR_PAD_LEFT);
        }

        return 'TS-' . date('ym') . $orderPad;
    }

    /**
     * Get pdf from current data.
     *
     * @param bool $stream
     * @return BinaryFileResponse|StreamedResponse
     */
    public function getPdf($stream = true)
    {
        $pdf = app('dompdf.wrapper')->loadView('take-stocks.print', ['takeStock' => $this]);

        if ($stream) {
            return $pdf->stream('take-stock.pdf');
        }

        return $pdf->download('take-stock.pdf');
    }
}
