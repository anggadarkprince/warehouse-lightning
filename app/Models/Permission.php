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

    const DOCUMENT_TYPE_VIEW = 'document-type-view';
    const DOCUMENT_TYPE_CREATE = 'document-type-create';
    const DOCUMENT_TYPE_EDIT = 'document-type-edit';
    const DOCUMENT_TYPE_DELETE = 'document-type-delete';

    const BOOKING_TYPE_VIEW = 'booking-view';
    const BOOKING_TYPE_CREATE = 'booking-create';
    const BOOKING_TYPE_EDIT = 'booking-edit';
    const BOOKING_TYPE_DELETE = 'booking-delete';

    const CUSTOMER_VIEW = 'customer-view';
    const CUSTOMER_CREATE = 'customer-create';
    const CUSTOMER_EDIT = 'customer-edit';
    const CUSTOMER_DELETE = 'customer-delete';

    const CONTAINER_VIEW = 'container-view';
    const CONTAINER_CREATE = 'container-create';
    const CONTAINER_EDIT = 'container-edit';
    const CONTAINER_DELETE = 'container-delete';

    const GOODS_VIEW = 'goods-view';
    const GOODS_CREATE = 'goods-create';
    const GOODS_EDIT = 'goods-edit';
    const GOODS_DELETE = 'goods-delete';

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
