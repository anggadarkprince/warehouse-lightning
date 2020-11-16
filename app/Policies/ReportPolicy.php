<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view inbound report models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewInbound(User $user)
    {
        return $user->hasPermission(Permission::REPORT_INBOUND);
    }

    /**
     * Determine whether the user can view outbound report models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewOutbound(User $user)
    {
        return $user->hasPermission(Permission::REPORT_OUTBOUND);
    }

    /**
     * Determine whether the user can view stock report models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewStockSummary(User $user)
    {
        return $user->hasPermission(Permission::REPORT_STOCK_SUMMARY);
    }

    /**
     * Determine whether the user can view movement report models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewStockMovement(User $user)
    {
        return $user->hasPermission(Permission::REPORT_STOCK_MOVEMENT);
    }
}
