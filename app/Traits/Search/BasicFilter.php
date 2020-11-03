<?php


namespace App\Traits\Search;


use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait BasicFilter
{
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
                if (in_array(DB::getSchemaBuilder()->getColumnType($this->getTable(), $column), ['date', 'datetime'])) {
                    try {
                        $q = Carbon::parse($q)->format('Y-m-d');
                    } catch (InvalidFormatException $e) {
                    }
                }
                $query->orWhere($column, 'LIKE', '%' . trim($q) . '%');
            }
        });
    }

    /**
     * Scope a query to sort group by specific column.
     *
     * @param Builder $query
     * @param $sortBy
     * @param string $sortMethod
     * @return Builder
     */
    public function scopeSort(Builder $query, $sortBy = 'created_at', $sortMethod = 'desc')
    {
        if (empty($sortBy)) {
            $sortBy = 'created_at';
        }
        if (empty($sortMethod)) {
            $sortMethod = 'desc';
        }
        return $query->orderBy($sortBy, $sortMethod);
    }

    /**
     * Scope a query to only include group of a greater date creation.
     *
     * @param Builder $query
     * @param $dateFrom
     * @return Builder
     */
    public function scopeDateFrom(Builder $query, $dateFrom)
    {
        if (empty($dateFrom)) return $query;

        try {
            $formattedData = Carbon::parse($dateFrom)->format('Y-m-d');
            return $query->where(DB::raw('DATE(created_at)'), '>=', $formattedData);
        } catch (InvalidFormatException $exception) {
            return $query;
        }
    }

    /**
     * Scope a query to only include group of a less date creation.
     *
     * @param Builder $query
     * @param $dateTo
     * @return Builder
     */
    public function scopeDateTo(Builder $query, $dateTo)
    {
        if (empty($dateTo)) return $query;

        try {
            $formattedData = Carbon::parse($dateTo)->format('Y-m-d');
            return $query->where(DB::raw('DATE(created_at)'), '<=', $formattedData);
        } catch (InvalidFormatException $exception) {
            return $query;
        }
    }
}
