<?php

namespace App\Utilities;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class QueryPrinter
{
    /**
     * Print query from builder.
     *
     * @param Builder $builder
     * @param bool $bindingWrapQuote
     * @return string
     */
    public static function from(Builder $builder, $bindingWrapQuote = true)
    {
        $bindings = collect($builder->getBindings());

        if ($bindingWrapQuote) {
            $bindings = $bindings->map(function ($binding) {
                return "'" . $binding . "'";
            });
        }

        return Str::replaceArray('?', $bindings->toArray(), $builder->toSql());
    }
}
