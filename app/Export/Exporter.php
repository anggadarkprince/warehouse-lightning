<?php


namespace App\Export;


use Illuminate\Support\Facades\Facade;

class Exporter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'exporter';
    }
}
