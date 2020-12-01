<?php

namespace App\Broadcasting;

use App\Models\DeliveryOrder;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Gate;

class BookingValidatedChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param User $user
     * @param $type
     * @return array|bool
     */
    public function join(User $user, $type)
    {
        if ($type == 'inbound') {
            return Gate::forUser($user)->allows('create', DeliveryOrder::class);
        }
        if ($type == 'outbound') {
            return Gate::forUser($user)->allows('create', WorkOrder::class);
        }
        return false;
    }
}
