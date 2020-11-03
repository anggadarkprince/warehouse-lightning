<?php

namespace App\Policies;

use App\Models\DeliveryOrder;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryOrderPolicy
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
        return $user->hasPermission(Permission::DELIVERY_ORDER_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param DeliveryOrder $deliveryOrder
     * @return mixed
     */
    public function view(User $user, DeliveryOrder $deliveryOrder)
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
        return $user->hasPermission(Permission::DELIVERY_ORDER_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param DeliveryOrder $deliveryOrder
     * @return mixed
     */
    public function update(User $user, DeliveryOrder $deliveryOrder)
    {
        return $user->hasPermission(Permission::DELIVERY_ORDER_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param DeliveryOrder $deliveryOrder
     * @return mixed
     */
    public function delete(User $user, DeliveryOrder $deliveryOrder)
    {
        return $user->hasPermission(Permission::DELIVERY_ORDER_DELETE);
    }
}
