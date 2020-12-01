<?php

namespace App\Broadcasting;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UploadValidatedChannel
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
     * @return array|bool
     */
    public function join(User $user)
    {
        return Gate::forUser($user)->allows('create', Booking::class);
    }
}
