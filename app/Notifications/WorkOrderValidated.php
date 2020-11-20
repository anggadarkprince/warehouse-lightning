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
        return ['mail', 'database'];
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
            ->action('Open ' . config('app.name'), route('dashboard'))
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
            'job_number' => $this->workOrder->job_number,
            'job_type' => $this->workOrder->job_type,
            'taken_by' => $notifiable->name,
            'completed_at' => $this->workOrder->completed_at,
            'message' => $this->message
        ];
    }
}
