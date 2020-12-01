<?php

use App\Broadcasting\BookingValidatedChannel;
use App\Broadcasting\JobAssignedChannel;
use App\Broadcasting\UploadValidatedChannel;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('job.assigned.{user}', JobAssignedChannel::class);
Broadcast::channel('upload.validated', UploadValidatedChannel::class);
Broadcast::channel('booking.{type}.validated', BookingValidatedChannel::class);
