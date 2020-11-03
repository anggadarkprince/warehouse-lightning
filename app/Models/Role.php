<?php

namespace App\Models;

use App\Traits\Search\BasicFilter;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use BasicFilter;

    protected $fillable = ['role', 'description'];

    /**
     * Get the permission of the group.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }
}
