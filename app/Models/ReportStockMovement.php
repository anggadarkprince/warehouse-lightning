<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\Exceptions\ParseErrorException;
use DateTimeInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportStockMovement
{
    /**
     * Get stock movement query.
     *
     * @param Request $request
     * @return Builder
     */
    public function getStockMovementContainer(Request $request)
    {
        /**
         * Create stock query with minimum group columns,
         * this query will be joined later to get additional data information.
         */
        $stockQuery = DB::table('bookings')
            ->select([
                DB::raw('IFNULL(booking_references.id, bookings.id) AS booking_id'),
                'work_orders.job_number',
                'work_orders.job_type',
                'users.name AS assigned_to',
                'work_orders.completed_at',
                'work_order_containers.container_id',
                'containers.container_number',
                'containers.container_type',
                'containers.container_size',
                DB::raw('work_order_containers.quantity * work_order_containers.multiplier AS quantity'),
            ])
            ->join('work_orders', function (JoinClause $join) {
                $join->on('work_orders.booking_id', '=', 'bookings.id')
                    ->where('work_orders.status', WorkOrder::STATUS_VALIDATED)
                    ->whereNull('work_orders.deleted_at');
            })
            ->join('work_order_containers', 'work_order_containers.work_order_id', '=', 'work_orders.id')
            ->join('containers', 'containers.id', '=', 'work_order_containers.container_id')
            ->leftJoin('users', 'users.id', '=', 'work_orders.user_id')
            ->leftJoin('work_order_references', function (JoinClause $join) {
                $join->on('work_order_references.reference_id', '=', 'work_order_containers.id')
                    ->where('work_order_references.reference_type', '=', 'reference-container');
            })
            ->leftJoin('work_order_containers AS work_order_container_sources', function (JoinClause $join) {
                $join->on('work_order_container_sources.id', '=', 'work_order_references.source_id')
                    ->where('work_order_references.source_type', '=', 'reference-container');
            })
            ->leftJoin('work_orders AS work_order_sources', 'work_order_sources.id', '=', 'work_order_container_sources.work_order_id')
            ->leftJoin('bookings AS booking_references', 'booking_references.id', '=', 'work_order_sources.booking_id')
            ->whereNull('bookings.deleted_at');

        /**
         * Stock cut by date of the activity
         */
        if ($request->has('stock_date') && $request->filled('stock_date')) {
            $stockDate = $request->input('stock_date');
            if (!$stockDate instanceof DateTimeInterface) {
                try {
                    $stockDate = Carbon::parse($request->input('stock_date'));
                } catch (ParseErrorException $e) {
                }
            }
            $stockQuery->whereDate('work_orders.completed_at', '>', $stockDate);
        }

        return $stockQuery;
    }

    /**
     * Calculate balance container.
     *
     * @param Builder $stockMovementQuery
     * @param Builder $stockQuery
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function calculateContainerBalance(Builder $stockMovementQuery, Builder $stockQuery, Request $request)
    {
        $stocks = $stockQuery->get();
        $stockMovements = $stockMovementQuery->get();

        return $stocks->map(function ($currentStock) use ($stockMovements, $request) {
            if (!$request->has('stock_date') || $request->isNotFilled('stock_date')) {
                $currentStock->quantity = 0;
                $currentStock->balance = 0;
            } else {
                $currentStock->balance = $currentStock->quantity;
            }
            $currentStock->transactions = $stockMovements
                ->where('container_id', $currentStock->container_id)
                ->values()
                ->map(function ($item) use (&$currentStock) {
                    $item->balance = $currentStock->balance;
                    $item->stock = $item->balance + $item->quantity;
                    $currentStock->balance = $item->stock;

                    return $item;
                });
            return $currentStock;
        });
    }

    /**
     * Get stock movement query.
     *
     * @param Request $request
     * @return Builder
     */
    public function getStockMovementGoods(Request $request)
    {
        /**
         * Create stock query with minimum group columns,
         * this query will be joined later to get additional data information.
         */
        $stockQuery = DB::table('bookings')
            ->select([
                DB::raw('IFNULL(booking_references.id, bookings.id) AS booking_id'),
                'work_orders.job_number',
                'work_orders.job_type',
                'users.name AS assigned_to',
                'work_orders.completed_at',
                'work_order_goods.goods_id',
                'goods.item_number',
                'goods.item_name',
                DB::raw('IFNULL(work_order_references.source_type, "reference-goods") AS source'),
                DB::raw('work_order_goods.unit_quantity * work_order_goods.multiplier AS quantity'),
                DB::raw('IFNULL(work_order_references.source_id, work_order_goods.id) AS source_id'),
            ])
            ->join('work_orders', function (JoinClause $join) {
                $join->on('work_orders.booking_id', '=', 'bookings.id')
                    ->where('work_orders.status', WorkOrder::STATUS_VALIDATED)
                    ->whereNull('work_orders.deleted_at');
            })
            ->join('work_order_goods', 'work_order_goods.work_order_id', '=', 'work_orders.id')
            ->join('goods', 'goods.id', '=', 'work_order_goods.goods_id')
            ->leftJoin('users', 'users.id', '=', 'work_orders.user_id')
            ->leftJoin('work_order_references', function(JoinClause $join) {
                $join->on('work_order_references.reference_id', '=', 'work_order_goods.id')
                    ->where('work_order_references.reference_type', '=', 'reference-goods');
            })
            ->leftJoin('work_order_containers AS work_order_container_sources', function(JoinClause  $join) {
                $join->on('work_order_container_sources.id', '=', 'work_order_references.source_id')
                    ->where('work_order_references.source_type', '=', 'reference-container');
            })
            ->leftJoin('work_order_goods AS work_order_goods_sources', function(JoinClause  $join) {
                $join->on('work_order_goods_sources.id', '=', 'work_order_references.source_id')
                    ->where('work_order_references.source_type', '=', 'reference-goods');
            })
            ->leftJoin('work_orders AS work_order_sources', 'work_order_sources.id', '=', DB::raw('IFNULL(work_order_container_sources.work_order_id, work_order_goods_sources.work_order_id)'))
            ->leftJoin('bookings AS booking_references', 'booking_references.id', '=', 'work_order_sources.booking_id')
            ->whereNull('bookings.deleted_at');

        /**
         * Stock cut by date of the activity
         */
        if ($request->has('stock_date') && $request->filled('stock_date')) {
            $stockDate = $request->input('stock_date');
            if (!$stockDate instanceof DateTimeInterface) {
                try {
                    $stockDate = Carbon::parse($request->input('stock_date'));
                } catch (ParseErrorException $e) {
                }
            }
            $stockQuery->whereDate('work_orders.completed_at', '>', $stockDate);
        }

        return $stockQuery;
    }


    /**
     * Calculate balance goods.
     *
     * @param Builder $stockMovementQuery
     * @param Builder $stockQuery
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function calculateGoodsBalance(Builder $stockMovementQuery, Builder $stockQuery, Request $request)
    {
        $stocks = $stockQuery->get();
        $stockMovements = $stockMovementQuery->get();

        return $stocks->map(function ($currentStock) use ($stockMovements, $request) {
            if (!$request->has('stock_date') || $request->isNotFilled('stock_date')) {
                $currentStock->quantity = 0;
                $currentStock->balance = 0;
            } else {
                $currentStock->balance = $currentStock->quantity;
            }
            $currentStock->transactions = $stockMovements
                ->where('goods_id', $currentStock->goods_id)
                ->where('source_id', $currentStock->source_id)
                ->values()
                ->map(function ($item) use (&$currentStock) {
                    $item->balance = $currentStock->balance;
                    $item->stock = $item->balance + $item->quantity;
                    $currentStock->balance = $item->stock;

                    return $item;
                });
            return $currentStock;
        });
    }

}
