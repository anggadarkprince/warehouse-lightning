<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkOrderPolicy
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
        return $user->hasPermission(Permission::WORK_ORDER_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param WorkOrder $workOrder
     * @return mixed
     */
    public function view(User $user, WorkOrder $workOrder)
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can take the model.
     *
     * @param User $user
     * @param WorkOrder $workOrder
     * @return mixed
     */
    public function take(User $user, WorkOrder $workOrder)
    {
        return $user->hasPermission(Permission::WORK_ORDER_TAKE) && $workOrder['user_id'] == $user['id'];
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(Permission::WORK_ORDER_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param WorkOrder $workOrder
     * @return mixed
     */
    public function update(User $user, WorkOrder $workOrder)
    {
        return $user->hasPermission(Permission::WORK_ORDER_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param WorkOrder $workOrder
     * @return mixed
     */
    public function delete(User $user, WorkOrder $workOrder)
    {
        return $user->hasPermission(Permission::WORK_ORDER_DELETE);
    }

}
