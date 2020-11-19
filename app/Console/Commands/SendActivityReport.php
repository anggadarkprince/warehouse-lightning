<?php

namespace App\Console\Commands;

use App\Mail\ActivityReport;
use App\Models\Permission;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendActivityReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'automate:activity
                            {job_type? : Job activity type}
                            {--date_from= : The activity from date (Y-m-d)}
                            {--date_to= : The activity until date (Y-m-d)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email activity report';

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
     * @param Report $report
     * @return int
     */
    public function handle(Report $report)
    {
        $jobType = $this->argument('job_type') ?: '';
        $dateFrom = $this->option('date_from') ?: Carbon::yesterday()->toDateString();
        $dateTo = $this->option('date_to') ?: Carbon::today()->toDateString();

        $request = new Request([
            'job_type' => $jobType,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
        ]);
        $containers = $report->getActivityContainers($request);
        $goods = $report->getActivityGoods($request);

        if ($containers->exists() || $goods->exists()) {
            $users = User::whereHas('roles', function (Builder $query) {
                $query->whereHas('permissions', function(Builder $query) {
                    $query->where('permission', Permission::REPORT_INBOUND);
                    $query->orWhere('permission', Permission::REPORT_OUTBOUND);
                });
            });
            if ($users->exists()) {
                $message = new ActivityReport($request, $containers->get(), $goods->get());
                Mail::to($users->get())->send($message);

                $this->info("{$jobType} activity from {$dateFrom} to {$dateTo} is successfully sent");
            } else {
                $this->line("No user available to receive the activity report");
            }
        } else {
            $this->error("No {$jobType} activity available");
        }

        return 0;
    }
}
