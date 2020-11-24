<?php

namespace App\Utilities;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class QueryPrinter
{
    /**
     * Print query from builder.
     *
     * @param $builder
     * @param bool $bindingWrapQuote
     * @return string
     */
    public static function from($builder, $bindingWrapQuote = true)
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
