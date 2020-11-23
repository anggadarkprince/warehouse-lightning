<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Dashboard extends Model
{
    /**
     * Get latest weekly booking.
     *
     * @return Builder
     */
    public function getTotalWeeklyBooking()
    {
        return DB::table('bookings')
            ->select([
                DB::raw('YEAR(bookings.created_at) AS year'),
                DB::raw('WEEK(bookings.created_at) AS week'),
                DB::raw('COUNT(bookings.id) AS total'),
            ])
            ->groupBy([
                DB::raw('YEAR(bookings.created_at)'),
                DB::raw('WEEK(bookings.created_at)'),
            ])
            ->orderByDesc('year')
            ->orderBy('week');
    }

    /**
     * Get latest weekly delivery.
     *
     * @return Builder
     */
    public function getTotalWeeklyDelivery()
    {
        return DB::table('delivery_orders')
            ->select([
                DB::raw('YEAR(delivery_orders.created_at) AS year'),
                DB::raw('WEEK(delivery_orders.created_at) AS week'),
                DB::raw('COUNT(delivery_orders.id) AS total'),
            ])
            ->groupBy([
                DB::raw('YEAR(delivery_orders.created_at)'),
                DB::raw('WEEK(delivery_orders.created_at)'),
            ])
            ->orderByDesc('year')
            ->orderBy('week');
    }

    /**
     * Get latest weekly job.
     *
     * @return Builder
     */
    public function getTotalWeeklyJob()
    {
        return DB::table('work_orders')
            ->select([
                DB::raw('YEAR(work_orders.created_at) AS year'),
                DB::raw('WEEK(work_orders.created_at) AS week'),
                DB::raw('COUNT(work_orders.id) AS total'),
            ])
            ->groupBy([
                DB::raw('YEAR(work_orders.created_at)'),
                DB::raw('WEEK(work_orders.created_at)'),
            ])
            ->orderByDesc('year')
            ->orderBy('week');
    }

    /**
     * Get stock container weekly
     */
    public function getStockContainer()
    {
        $reportStock = new ReportStock();
        return Collection::times(10)->map(function ($value) use ($reportStock) {
            $stock = $reportStock->getStockContainers(new Request([
                'stock_date' => $date = Carbon::now()->subWeeks($value - 1)
            ]));

            $groupStock = $stock->groupBy('container_size')
                ->select('container_size')
                ->selectRaw('COUNT(container_size) AS total')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->container_size => $item->total];
                });

            if (!$groupStock->has('20')) $groupStock[20] = 0;
            if (!$groupStock->has('40')) $groupStock[40] = 0;
            if (!$groupStock->has('45')) $groupStock[45] = 0;

            return collect([
                'date' => $date->toDateString(),
                'stocks' => $groupStock
            ]);
        });
    }

    /**
     * Get stock goods weekly
     */
    public function getStockGoods()
    {
        $reportStock = new ReportStock();
        return Collection::times(10)->map(function ($value) use ($reportStock) {
            $stock = $reportStock->getStockGoods(new Request([
                'stock_date' => $date = Carbon::now()->subWeeks($value - 1)
            ]));

            return collect([
                'date' => $date->toDateString(),
                'stocks' => $stock->count()
            ]);
        });
    }
}
