<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\Exceptions\ParseErrorException;
use DateTimeInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportStock
{
    /**
     * Get report stock container.
     *
     * @param Request $request
     * @return Builder
     */
    public function getStockContainers(Request $request)
    {
        /**
         * Create stock query with minimum group columns,
         * this query will be joined later to get additional data information.
         */
        $stockQuery = DB::table('bookings')
            ->select([
                DB::raw('IFNULL(booking_references.id, bookings.id) AS booking_id'),
                'work_order_containers.container_id',
                DB::raw('SUM(work_order_containers.quantity * work_order_containers.multiplier) AS quantity'),
                DB::raw('MAX(work_order_containers.id) AS latest_work_order_container_id'),
                DB::raw('MAX(work_order_references.source_id) AS source_id'),
            ])
            ->join('work_orders', function (JoinClause $join) {
                $join->on('work_orders.booking_id', '=', 'bookings.id')
                    ->where('work_orders.status', WorkOrder::STATUS_VALIDATED)
                    ->whereNull('work_orders.deleted_at');
            })
            ->join('work_order_containers', 'work_order_containers.work_order_id', '=', 'work_orders.id')
            ->leftJoin('work_order_references', function(JoinClause $join) {
                $join->on('work_order_references.reference_id', '=', 'work_order_containers.id')
                    ->where('work_order_references.reference_type', '=', 'reference-container');
            })
            ->leftJoin('work_order_containers AS work_order_container_sources', function(JoinClause  $join) {
                $join->on('work_order_container_sources.id', '=', 'work_order_references.source_id')
                    ->where('work_order_references.source_type', '=', 'reference-container');
            })
            ->leftJoin('work_orders AS work_order_sources', 'work_order_sources.id', '=', 'work_order_container_sources.work_order_id')
            ->leftJoin('bookings AS booking_references', 'booking_references.id', '=', 'work_order_sources.booking_id')
            ->whereNull('bookings.deleted_at')
            ->groupBy([
                'booking_id',
                'container_id',
            ]);

        /**
         * Apply stock data and date filter
         */
        $this->applyStockFilter($stockQuery, $request);

        /**
         * Join stock query with necessary table, to complete stock report,
         * the add filter about it.
         */
        $baseQuery = DB::table('bookings')
            ->select([
                'bookings.id AS booking_id',
                'bookings.reference_number',
                'bookings.booking_number',
                'customers.customer_name',
                'containers.id AS container_id',
                'containers.container_number',
                'containers.container_type',
                'containers.container_size',
                'work_order_containers.seal',
                'work_order_containers.is_empty',
                'stock_containers.quantity',
                'work_order_containers.description',
                'work_orders.job_number AS latest_job_number',
                'work_orders.job_type AS latest_job_type',
                'work_orders.id AS latest_job_id',
                'stock_containers.source_id',
                DB::raw('IFNULL(stock_containers.source_id, stock_containers.latest_work_order_container_id) AS source_id')
            ])
            ->joinSub($stockQuery, 'stock_containers', function(JoinClause $join) {
                $join->on('bookings.id', '=', 'stock_containers.booking_id');
            })
            ->join('containers', 'containers.id', '=', 'stock_containers.container_id')
            ->join('customers', 'customers.id', '=', 'bookings.customer_id')
            ->join('work_order_containers', 'work_order_containers.id', '=', 'stock_containers.latest_work_order_container_id')
            ->join('work_orders', 'work_orders.id', '=', 'work_order_containers.work_order_id');

        /**
         * Search by query keyword of necessary columns
         */
        if ($request->has('q') && $request->filled('q')) {
            $q = trim($request->input('q'), '');
            $baseQuery->where(function (Builder $query) use ($q) {
                $query->orWhere('reference_number', 'LIKE', '%' . $q . '%');
                $query->orWhere('booking_number', 'LIKE', '%' . $q . '%');
                $query->orWhere('customer_name', 'LIKE', '%' . $q . '%');
                $query->orWhere('container_number', 'LIKE', '%' . $q . '%');
                $query->orWhere('container_type', 'LIKE', '%' . $q . '%');
                $query->orWhere('container_size', 'LIKE', '%' . $q . '%');
                $query->orWhere('seal', 'LIKE', '%' . $q . '%');
                $query->orWhere('description', 'LIKE', '%' . $q . '%');
            });
        }

        /**
         * Apply container profile filter
         */
        $this->applyContainerFilter($baseQuery, $request);

        /**
         * Apply owner profile filter
         */
        $this->applyOwnerFilter($baseQuery, $request);

        return $baseQuery;
    }

    /**
     * Get report stock goods.
     *
     * @param Request $request
     * @return Builder
     */
    public function getStockGoods(Request $request)
    {
        /**
         * Create stock query with minimum group columns,
         * this query will be joined later to get additional data information.
         */
        $stockQuery = DB::table('bookings')
            ->select([
                DB::raw('IFNULL(booking_references.id, bookings.id) AS booking_id'),
                'work_order_goods.goods_id',
                DB::raw('IFNULL(work_order_references.source_type, "reference-goods") AS source'),
                DB::raw('SUM(work_order_goods.unit_quantity * work_order_goods.multiplier) AS quantity'),
                DB::raw('SUM(work_order_goods.unit_quantity * work_order_goods.multiplier) AS unit_quantity'),
                DB::raw('SUM(work_order_goods.package_quantity * work_order_goods.multiplier) AS package_quantity'),
                DB::raw('SUM(work_order_goods.weight * work_order_goods.multiplier) AS weight'),
                DB::raw('SUM(work_order_goods.gross_weight * work_order_goods.multiplier) AS gross_weight'),
                DB::raw('MAX(work_order_goods.id) AS latest_work_order_goods_id'),
                DB::raw('MAX(work_order_references.source_id) AS source_id'),
            ])
            ->join('work_orders', function (JoinClause $join) {
                $join->on('work_orders.booking_id', '=', 'bookings.id')
                    ->where('work_orders.status', WorkOrder::STATUS_VALIDATED)
                    ->whereNull('work_orders.deleted_at');
            })
            ->join('work_order_goods', 'work_order_goods.work_order_id', '=', 'work_orders.id')
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
            ->whereNull('bookings.deleted_at')
            ->groupBy([
                'booking_id',
                'goods_id',
                'source'
            ]);

        /**
         * Apply stock data and date filter
         */
        $this->applyStockFilter($stockQuery, $request);

        /**
         * Join stock query with necessary table, to complete stock report,
         * the add filter about it.
         */
        $baseQuery = DB::table('bookings')
            ->select([
                'bookings.id AS booking_id',
                'bookings.reference_number',
                'bookings.booking_number',
                'customers.customer_name',
                'goods.id AS goods_id',
                'goods.item_number',
                'goods.item_name',
                'goods.unit_name',
                'goods.package_name',
                'stock_goods.unit_quantity AS quantity',
                'stock_goods.unit_quantity',
                'stock_goods.package_quantity',
                'stock_goods.weight',
                'stock_goods.gross_weight',
                'containers.container_number',
                'work_order_goods.description',
                'work_orders.job_number AS latest_job_number',
                'work_orders.job_type AS latest_job_type',
                'work_orders.id AS latest_job_id',
                'stock_goods.source_id',
                DB::raw('IFNULL(stock_goods.source_id, stock_goods.latest_work_order_goods_id) AS source_id')
            ])
            ->joinSub($stockQuery, 'stock_goods', function(JoinClause $join) {
                $join->on('bookings.id', '=', 'stock_goods.booking_id');
            })
            ->join('goods', 'goods.id', '=', 'stock_goods.goods_id')
            ->join('customers', 'customers.id', '=', 'bookings.customer_id')
            ->join('work_order_goods', 'work_order_goods.id', '=', 'stock_goods.latest_work_order_goods_id')
            ->join('work_orders', 'work_orders.id', '=', 'work_order_goods.work_order_id')
            ->leftJoin('work_order_containers', function (JoinClause $join) {
                $join->on('work_order_containers.id', '=', 'stock_goods.source_id')
                    ->where('stock_goods.source', '=', 'reference-container');
            })
            ->leftJoin('containers', 'containers.id', '=', 'work_order_containers.container_id');

        /**
         * Search by query keyword of necessary columns
         */
        if ($request->has('q') && $request->filled('q')) {
            $q = trim($request->input('q'), '');
            $baseQuery->where(function (Builder $query) use ($q) {
                $query->orWhere('reference_number', 'LIKE', '%' . $q . '%');
                $query->orWhere('booking_number', 'LIKE', '%' . $q . '%');
                $query->orWhere('customer_name', 'LIKE', '%' . $q . '%');
                $query->orWhere('item_name', 'LIKE', '%' . $q . '%');
                $query->orWhere('item_number', 'LIKE', '%' . $q . '%');
                $query->orWhere('container_number', 'LIKE', '%' . $q . '%');
                $query->orWhere('description', 'LIKE', '%' . $q . '%');
            });
        }

        /**
         * Apply container profile filter
         */
        $this->applyGoodsFilter($baseQuery, $request);

        /**
         * Apply owner profile filter
         */
        $this->applyOwnerFilter($baseQuery, $request);

        if ($request->has('container_number') && $request->filled('container_number')) {
            $baseQuery->where('container_number', $request->input('container_number'));
        }

        return $baseQuery;
    }

    /**
     * Apply builder general stock filter.
     *
     * @param Builder $stockQuery
     * @param Request $request
     */
    protected function applyStockFilter(Builder $stockQuery, Request $request)
    {
        /**
         * Determine data of the stock, available options:
         * - all-data: All stock data of booking
         * - stocked: Only available stock (more than 0 quantity)
         * - empty-stock: Only zero quantity
         * - negative-stock: Only negative stock (needed in take stock feature, checking error)
         * - inactive-stock: Zero and bellow stock
         */
        $stock = $request->input('data', 'stock');
        switch ($stock) {
            case 'all-data':
            case 'all':
                break;
            case 'stocked':
            case 'stock-only':
            case 'stock':
            default:
                $stockQuery->having('quantity', '>', '0');
                break;
            case 'empty-stock':
                $stockQuery->having('quantity', '=', '0');
                break;
            case 'negative-stock':
                $stockQuery->having('quantity', '<', '0');
                break;
            case 'inactive-stock':
                $stockQuery->having('quantity', '<=', '0');
                break;
        }

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
            $stockQuery->whereDate('work_orders.completed_at', '<=', $stockDate);
        }
    }

    /**
     * Apply booking and customer filter.
     *
     * @param Builder $baseQuery
     * @param Request $request
     */
    protected function applyOwnerFilter(Builder $baseQuery, Request $request)
    {
        if ($request->has('customer_id') && $request->filled('customer_id')) {
            $baseQuery->where('customers.id', $request->input('customer_id'));
        }

        if ($request->has('booking_id') && $request->filled('booking_id')) {
            $baseQuery->where('bookings.id', $request->input('booking_id'));
        }
    }

    /**
     * Apply container profile filter.
     *
     * @param Builder $baseQuery
     * @param Request $request
     */
    protected function applyContainerFilter(Builder $baseQuery, Request $request)
    {
        if ($request->has('container_id') && $request->filled('container_id')) {
            $baseQuery->where('containers.id', $request->input('container_id'));
        }

        if ($request->has('container_size') && $request->filled('container_size')) {
            $baseQuery->where('containers.container_size', $request->input('container_size'));
        }

        if ($request->has('container_type') && $request->filled('container_type')) {
            $baseQuery->where('containers.container_type', $request->input('container_type'));
        }

        if ($request->has('is_empty') && $request->filled('is_empty')) {
            $baseQuery->where('work_order_containers.is_empty', $request->input('is_empty'));
        }

    }

    /**
     * Apply goods profile filter.
     *
     * @param Builder $baseQuery
     * @param Request $request
     */
    protected function applyGoodsFilter(Builder $baseQuery, Request $request)
    {
        if ($request->has('item_number') && $request->filled('item_number')) {
            $baseQuery->where('goods.item_number', $request->input('item_number'));
        }

        if ($request->has('goods_id') && $request->filled('goods_id')) {
            $baseQuery->where('goods.id', $request->input('goods_id'));
        }
    }

}
