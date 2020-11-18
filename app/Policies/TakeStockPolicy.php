<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\TakeStock;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TakeStockPolicy
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
        return $user->hasPermission(Permission::TAKE_STOCK_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param TakeStock $takeStock
     * @return mixed
     */
    public function view(User $user, TakeStock $takeStock)
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
        return $user->hasPermission(Permission::TAKE_STOCK_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param TakeStock $takeStock
     * @return mixed
     */
    public function update(User $user, TakeStock $takeStock)
    {
        return $user->hasPermission(Permission::TAKE_STOCK_EDIT) && in_array($takeStock->status, [TakeStock::STATUS_PENDING, TakeStock::STATUS_REJECTED, TakeStock::STATUS_IN_PROCESS]);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param TakeStock $takeStock
     * @return mixed
     */
    public function delete(User $user, TakeStock $takeStock)
    {
        return $user->hasPermission(Permission::TAKE_STOCK_DELETE) && $takeStock->status != TakeStock::STATUS_VALIDATED;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param TakeStock $takeStock
     * @return mixed
     */
    public function validate(User $user, TakeStock $takeStock)
    {
        return $user->hasPermission(Permission::TAKE_STOCK_VALIDATE) && $takeStock->status == TakeStock::STATUS_SUBMITTED;
    }
}
