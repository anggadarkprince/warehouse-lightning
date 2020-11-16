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
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission(Permission::TAKE_STOCK_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TakeStock  $takeStock
     * @return mixed
     */
    public function view(User $user, TakeStock $takeStock)
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(Permission::TAKE_STOCK_CREATE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TakeStock  $takeStock
     * @return mixed
     */
    public function delete(User $user, TakeStock $takeStock)
    {
        return $user->hasPermission(Permission::TAKE_STOCK_DELETE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TakeStock  $takeStock
     * @return mixed
     */
    public function validate(User $user, TakeStock $takeStock)
    {
        return $user->hasPermission(Permission::TAKE_STOCK_VALIDATE);
    }
}
