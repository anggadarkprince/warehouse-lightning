<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Models\WorkOrder;

class JobChannel
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
     * @param User $assignedTo
     * @return array|bool
     */
    public function join(User $user, User $assignedTo)
    {
        return $user->id === $assignedTo->id;
    }
}
