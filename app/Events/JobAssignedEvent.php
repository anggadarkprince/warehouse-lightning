<?php

namespace App\Events;

use App\Models\WorkOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobAssignedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $workOrder;

    /**
     * Create a new event instance.
     *
     * @param WorkOrder $workOrder
     */
    public function __construct(WorkOrder $workOrder)
    {
        $this->workOrder = $workOrder;
    }
}
