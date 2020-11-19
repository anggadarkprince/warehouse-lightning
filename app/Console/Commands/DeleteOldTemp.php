<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteOldTemp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'automate:delete-old-temp {--O|old=7 : Old file more than n days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete temporary file more than given days';

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
     * @return int
     */
    public function handle()
    {
        $oldDays = $this->option('old');
        $files = Storage::files('temp');

        $deletedFiles = collect($files)
            ->filter(function ($file) use ($oldDays) {
                $today = Carbon::now();
                $fileTimestamp = Carbon::createFromTimestamp(filectime(storage_path('app/' . $file)));
                $interval = $today->diff($fileTimestamp)->format('%R%a');
                if (intval($interval) <= -$oldDays) {
                    $this->info($file . ' ' . $fileTimestamp->toDateTimeString() . ' with old days: ' . $interval . ' to be deleted');
                    return true;
                }
                return false;
            });

        return Storage::delete($deletedFiles->toArray());
    }
}
