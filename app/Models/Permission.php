<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    const ROLE_VIEW = 'role-view';
    const ROLE_CREATE = 'role-create';
    const ROLE_EDIT = 'role-edit';
    const ROLE_DELETE = 'role-delete';

    const USER_VIEW = 'user-view';
    const USER_CREATE = 'user-create';
    const USER_EDIT = 'user-edit';
    const USER_DELETE = 'user-delete';

    const ACCOUNT_EDIT = 'account-edit';
    const SETTING_EDIT = 'setting-edit';

    /**
     * Get the group of the permission.
     */
    public function permissions()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
