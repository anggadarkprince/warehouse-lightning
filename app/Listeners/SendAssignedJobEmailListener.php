<?php

namespace App\Listeners;

use App\Events\JobAssignedEvent;
use App\Mail\JobAssignment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendAssignedJobEmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param JobAssignedEvent $event
     * @return void
     */
    public function handle(JobAssignedEvent $event)
    {
        Mail::to($event->workOrder->user)->send(new JobAssignment($event->workOrder));
    }
}
