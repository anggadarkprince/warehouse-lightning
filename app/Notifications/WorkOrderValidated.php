<?php

namespace App\Notifications;

use App\Models\WorkOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkOrderValidated extends Notification implements ShouldQueue
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
        return 'job.validated';
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
            ->subject("Work order {$jobNumber} ({$jobType}) is validated")
            ->greeting('Hi, ' . $notifiable->name)
            ->line('The job already validated, this process may change the stock.')
            ->line('Note: ' . $this->message ?: '-')
            ->action('Open ' . config('app.name'), route('dashboard', ['locale' => app_setting('app-language', app()->getLocale())]))
            ->attachData($this->workOrder->getPdf(), 'Work Order.pdf', [
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'customer' => $this->workOrder->booking->customer->customer_name,
            'reference_number' => $this->workOrder->booking->reference_number,
            'job_number' => $this->workOrder->job_number,
            'job_type' => $this->workOrder->job_type,
            'taken_by' => $notifiable->name,
            'completed_at' => $this->workOrder->completed_at,
            'message' => $this->message
        ];
    }
}
