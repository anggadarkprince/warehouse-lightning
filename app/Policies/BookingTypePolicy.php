<?php

namespace App\Policies;

use App\Models\BookingType;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingTypePolicy
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
        return $user->hasPermission(Permission::BOOKING_TYPE_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param BookingType $bookingType
     * @return mixed
     */
    public function view(User $user, BookingType $bookingType)
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
        return $user->hasPermission(Permission::BOOKING_TYPE_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param BookingType $bookingType
     * @return mixed
     */
    public function update(User $user, BookingType $bookingType)
    {
        return $user->hasPermission(Permission::BOOKING_TYPE_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param BookingType $bookingType
     * @return mixed
     */
    public function delete(User $user, BookingType $bookingType)
    {
        return $user->hasPermission(Permission::BOOKING_TYPE_DELETE);
    }
}
