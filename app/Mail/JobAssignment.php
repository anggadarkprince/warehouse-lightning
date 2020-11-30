<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobAssignment extends Mailable
{
    use Queueable, SerializesModels;

    public $workOrder;

    /**
     * Create a new message instance.
     *
     * @param $workOrder
     */
    public function __construct($workOrder)
    {
        $this->workOrder = $workOrder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.work-orders.assignment')
            ->locale(app()->getLocale())
            ->subject('Job ' . $this->workOrder->job_type . ' assigned to ' . $this->workOrder->user->name);
    }
}
