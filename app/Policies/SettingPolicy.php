<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can edit application setting.
     *
     * @param User $user
     * @return mixed
     */
    public function editSetting(User $user)
    {
        return $user->hasPermission(Permission::SETTING_EDIT);
    }
}
