<?php

namespace App\Providers;

use App\Export\CollectionExporter;
use Illuminate\Support\ServiceProvider;

class ExporterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('exporter',function(){
            return new CollectionExporter();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
