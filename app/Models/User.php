<?php

namespace App\Models;

use App\Traits\Search\BasicFilter;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable, BasicFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'email_verified_at',
        'last_logged_in',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_logged_in' => 'datetime',
    ];

    /**
     * Get the avatar image.
     *
     * @param mixed $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return empty($value) ? url('/img/no-image.png') : Storage::disk('public')->url($value);
    }

    /**
     * Get the role of the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * Get the permissions of the user.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePermissions(Builder $query)
    {
        return $query
            ->select([
                'permissions.permission',
                'permissions.description',
            ])
            ->distinct()
            ->join('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_roles.role_id')
            ->join('role_permissions', 'role_permissions.role_id', '=', 'roles.id')
            ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id');
    }

    /**
     * Check the permissions is owned by user.
     *
     * @param Builder $query
     * @param $permission
     * @return int
     */
    public function scopeHasPermission(Builder $query, $permission) {
        if ($this->isAdministrator()) {
            return true;
        }

        $hasPermission = $this->scopePermissions($query)->where('permission', $permission)->get();

        return $hasPermission->count() > 0;
    }


    /**
     * Scope a query to only include user that match the query.
     *
     * @param Builder $query
     * @param string $q
     * @return Builder
     */
    public function scopeQ(Builder $query, $q = '')
    {
        if (empty($q)) {
            return $query;
        }
        $columns = Schema::getColumnListing($this->getTable());
        return $query->where(function (Builder $query) use ($q, $columns) {
            foreach ($columns as $column) {
                if (in_array(DB::getSchemaBuilder()->getColumnType($this->getTable(), $column), ['date', 'datetime'])) {
                    try {
                        $q = Carbon::parse($q)->format('Y-m-d');
                    } catch (InvalidFormatException $e) {
                    }
                }
                $query->orWhere($column, 'LIKE', '%' . trim($q) . '%');
            }
            $query->orWhereHas('roles', function (Builder $query) use ($q) {
                $query->where('role', 'LIKE', '%' . $q . '%');
            });
        });
    }

    /**
     * Check if user is super admin.
     *
     * @return bool
     */
    public function isAdministrator()
    {
        return $this->email === 'admin@warehouse.app' || $this->is_admin;
    }
}
