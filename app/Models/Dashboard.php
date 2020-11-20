<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
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
}
