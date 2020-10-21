<?php

namespace App\Policies;

use App\Models\Container;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContainerPolicy
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
        return $user->hasPermission(Permission::CONTAINER_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Container $container
     * @return mixed
     */
    public function view(User $user, Container $container)
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
        return $user->hasPermission(Permission::CONTAINER_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Container $container
     * @return mixed
     */
    public function update(User $user, Container $container)
    {
        return $user->hasPermission(Permission::CONTAINER_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Container $container
     * @return mixed
     */
    public function delete(User $user, Container $container)
    {
        return $user->hasPermission(Permission::CONTAINER_DELETE);
    }
}
