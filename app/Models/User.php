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
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Passport\HasApiTokens;
use Laravel\Scout\Searchable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, BasicFilter, Searchable, TwoFactorAuthenticatable;

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
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'users.notification.'.$this->id;
    }

    /**
     * Get the avatar image.
     *
     * @param mixed $value
     * @return string
     */
    public function getAvatarUrlAttribute($value)
    {
        return empty($this->avatar) ? url('/img/no-image.png') : Storage::disk('public')->url($this->avatar);
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
     * @param null $userId
     * @return int
     */
    public function scopeHasPermission(Builder $query, $permission, $userId = null) {
        if ($this->isAdministrator()) {
            return true;
        }

        $hasPermission = $this->scopePermissions($query)
            ->where('permission', $permission)
            ->where('users.id', $userId ?: $this->id)
            ->get();

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

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => optional(optional($this->roles)->pluck('role'))->implode(',')
        ];
    }

    /**
     * Determine if the model should be searchable.
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        return !$this->isAdministrator();
    }
}
