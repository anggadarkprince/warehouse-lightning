<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Upload;
use App\Models\WorkOrder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'upload' => Upload::class,
            'booking' => Booking::class,
            'work-order' => WorkOrder::class,
        ]);
    }
}
