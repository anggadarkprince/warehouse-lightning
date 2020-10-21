<?php

namespace App\Policies;

use App\Models\Goods;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GoodsPolicy
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
        return $user->hasPermission(Permission::GOODS_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Goods $goods
     * @return mixed
     */
    public function view(User $user, Goods $goods)
    {
        $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(Permission::GOODS_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Goods $goods
     * @return mixed
     */
    public function update(User $user, Goods $goods)
    {
        return $user->hasPermission(Permission::GOODS_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Goods $goods
     * @return mixed
     */
    public function delete(User $user, Goods $goods)
    {
        return $user->hasPermission(Permission::GOODS_DELETE);
    }
}
