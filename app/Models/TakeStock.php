<?php

namespace App\Models;

use App\Contracts\Numerable\HasOrderNumber;
use App\Traits\Search\BasicFilter;
use Illuminate\Database\Eloquent\Model;

class TakeStock extends Model implements HasOrderNumber
{
    use BasicFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['status', 'description'];

    const STATUS_IN_PROCESS = 'IN PROCESS';
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
}
