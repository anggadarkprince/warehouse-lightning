<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UploadPolicy
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
        return $user->hasPermission(Permission::UPLOAD_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Upload $upload
     * @return mixed
     */
    public function view(User $user, Upload $upload)
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
        return $user->hasPermission(Permission::UPLOAD_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Upload $upload
     * @return mixed
     */
    public function update(User $user, Upload $upload)
    {
        return $user->hasPermission(Permission::UPLOAD_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Upload $upload
     * @return mixed
     */
    public function delete(User $user, Upload $upload)
    {
        return $user->hasPermission(Permission::UPLOAD_DELETE);
    }
}
