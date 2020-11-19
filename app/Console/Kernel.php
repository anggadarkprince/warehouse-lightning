<?php

namespace App\Console;

use App\Console\Commands\CreateAdminUser;
use App\Console\Commands\DeleteOldTemp;
use App\Console\Commands\SendActivityReport;
use App\Console\Commands\SendStockSummaryReport;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CreateAdminUser::class,
        DeleteOldTemp::class,
        SendActivityReport::class,
        SendStockSummaryReport::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('automate:delete-old-temp')->daily()->appendOutputTo(storage_path('logs/deleted-temp.log'));
        $schedule->command('automate:activity', ['UNLOADING'])->daily()->appendOutputTo(storage_path('logs/unloading-activity.log'));
        $schedule->command('automate:activity', ['LOADING'])->daily()->appendOutputTo(storage_path('logs/loading-activity.log'));
        $schedule->command('automate:stock', ['--stock_date=' . Carbon::now()->subWeek()->toDateString()])->weeklyOn(1, '1:00')->appendOutputTo(storage_path('logs/stock.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
