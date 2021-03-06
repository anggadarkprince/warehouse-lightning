<?php

namespace App\Notifications;

use App\Models\WorkOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkOrderRejected extends Notification implements ShouldQueue
{
    use Queueable;

    private $workOrder;
    private $message;

    /**
     * Create a new notification instance.
     *
     * @param WorkOrder $workOrder
     * @param $message
     */
    public function __construct(WorkOrder $workOrder, $message)
    {
        $this->workOrder = $workOrder;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->id == $this->workOrder->user_id ? ['mail', 'database', 'broadcast'] : [];
    }

    /**
     * Get the type of the notification being broadcast.
     *
     * @return string
     */
    public function broadcastType()
    {
        return 'job.rejected';
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $jobNumber = $this->workOrder->job_number;
        $jobType = $this->workOrder->job_type;

        return (new MailMessage)
            ->error()
            ->subject("Work order {$jobNumber} ({$jobType}) is REJECTED")
            ->greeting('Hi, ' . $notifiable->name)
            ->line('The job is rejected, please read note below if something need to be fixed.')
            ->line('Note: ' . $this->message ?: '-')
            ->action('Open Job Queue', route('tally.index', ['locale' => app_setting('app-language', app()->getLocale())]))
            ->attachData($this->workOrder->getPdf(), 'Work Order Rejected.pdf', [
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->workOrder->id,
            'job_number' => $this->workOrder->job_number,
            'job_type' => $this->workOrder->job_type,
            'taken_by' => $notifiable->name,
            'completed_at' => $this->workOrder->completed_at,
            'message' => $this->message
        ];
    }

    /**
     * Broadcast information to user.
     *
     * @param $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => $this->workOrder->id,
            'customer' => $this->workOrder->booking->customer->customer_name,
            'job_number' => $this->workOrder->job_number,
            'job_type' => $this->workOrder->job_type,
            'taken_by' => $notifiable->name,
            'message' => $this->message
        ]);
    }
}
