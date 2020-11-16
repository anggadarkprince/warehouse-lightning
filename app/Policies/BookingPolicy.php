<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission(Permission::BOOKING_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Booking $booking
     * @return mixed
     */
    public function view(User $user, Booking $booking)
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(Permission::BOOKING_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Booking $booking
     * @return mixed
     */
    public function update(User $user, Booking $booking)
    {
        return $user->hasPermission(Permission::BOOKING_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Booking $booking
     * @return mixed
     */
    public function delete(User $user, Booking $booking)
    {
        return $user->hasPermission(Permission::BOOKING_DELETE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User $user
     * @param Booking $booking
     * @return mixed
     */
    public function validate(User $user, Booking $booking)
    {
        return $user->hasPermission(Permission::BOOKING_VALIDATE);
    }
}
