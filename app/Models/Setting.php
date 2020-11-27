<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'setting_key';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['setting_key', 'setting_value'];

    const APP_TITLE = 'app-title';
    const APP_TAGLINE = 'app-tagline';
    const APP_DESCRIPTION = 'app-description';
    const APP_KEYWORDS = 'app-keywords';
    const APP_LANGUAGE = 'app-language';

    const MANAGEMENT_REGISTRATION = 'management-registration';
    const DEFAULT_MANAGEMENT_GROUP = 'default-management-group';

    const EMAIL_SUPPORT = 'email-support';
    const EMAIL_BUG_REPORT = 'email-bug-report';

    const MAINTENANCE_FRONTEND = 'maintenance-frontend';

    /**
     * Get setting item by key.
     *
     * @param Builder $query
     * @param $key
     * @param string $default
     * @return string
     */
    public function scopeItem(Builder $query, $key, $default = '')
    {
        return Cache::remember($key, 60 * 60 * 24, function () use ($query, $key, $default) {
            $result = $query->where('setting_key', $key)->first();

            if (empty($result)) {
                return $default;
            }

            return $result->setting_value ?: $default;
        });
    }
}
