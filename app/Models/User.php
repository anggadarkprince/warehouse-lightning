<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        return $query->where(function (Builder $query) use ($q) {
            $query->where('users.name', 'LIKE', '%' . $q . '%');
            $query->orWhere('users.email', 'LIKE', '%' . $q . '%');
            $query->orWhere('users.type', 'LIKE', '%' . $q . '%');
            $query->orWhereHas('groups', function (Builder $query) use ($q) {
                $query->where('group', 'LIKE', '%' . $q . '%');
            });
        });
    }

    /**
     * Scope a query to sort user by specific column.
     *
     * @param Builder $query
     * @param $sortBy
     * @param string $sortMethod
     * @return Builder
     */
    public function scopeSort(Builder $query, $sortBy = 'users.created_at', $sortMethod = 'desc')
    {
        if (empty($sortBy)) {
            $sortBy = 'users.created_at';
        }
        if (empty($sortMethod)) {
            $sortMethod = 'desc';
        }
        return $query->orderBy($sortBy, $sortMethod);
    }

    /**
     * Scope a query to only include group of a greater date creation.
     *
     * @param Builder $query
     * @param $dateFrom
     * @return Builder
     */
    public function scopeDateFrom(Builder $query, $dateFrom)
    {
        if (empty($dateFrom)) return $query;

        try {
            $formattedData = Carbon::parse($dateFrom)->format('Y-m-d');
            return $query->where(DB::raw('DATE(users.created_at)'), '>=', $formattedData);
        } catch (InvalidFormatException $exception) {
            return $query;
        }
    }

    /**
     * Scope a query to only include group of a less date creation.
     *
     * @param Builder $query
     * @param $dateTo
     * @return Builder
     */
    public function scopeDateTo(Builder $query, $dateTo)
    {
        if (empty($dateTo)) return $query;

        try {
            $formattedData = Carbon::parse($dateTo)->format('Y-m-d');
            return $query->where(DB::raw('DATE(users.created_at)'), '<=', $formattedData);
        } catch (InvalidFormatException $exception) {
            return $query;
        }
    }

    /**
     * Check if user is super admin.
     *
     * @return bool
     */
    public function isAdministrator()
    {
        return $this->email === 'admin@warehouse.app';
    }
}
