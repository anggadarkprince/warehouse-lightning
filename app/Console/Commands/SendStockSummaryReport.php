<?php

namespace App\Console\Commands;

use App\Mail\ActivityReport;
use App\Mail\StockReport;
use App\Models\Permission;
use App\Models\ReportStock;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendStockSummaryReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'automate:stock {--stock_date= : Date of stock cut off}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email stock summary';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param ReportStock $reportStock
     * @return int
     */
    public function handle(ReportStock $reportStock)
    {
        $stockDate = $this->option('stock_date') ?: Carbon::today()->toDateString();

        $request = new Request(['stock_date' => $stockDate]);
        $containers = $reportStock->getStockContainers($request);
        $goods = $reportStock->getStockGoods($request);

        if ($containers->exists() || $goods->exists()) {
            $users = User::whereHas('roles', function (Builder $query) {
                $query->whereHas('permissions', function(Builder $query) {
                    $query->where('permission', Permission::REPORT_STOCK_SUMMARY);
                });
            });
            if ($users->exists()) {
                $message = new StockReport($stockDate, $containers->get(), $goods->get());
                Mail::to($users->get())->send($message);

                $this->info("Stock report at  {$stockDate} is successfully sent");
            } else {
                $this->line("No user available to receive the stock report");
            }
        } else {
            $this->error("No stock at {$stockDate} available");
        }

        return 0;
    }
}
