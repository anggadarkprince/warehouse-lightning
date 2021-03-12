<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class FrontEndMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (app_setting(Setting::MAINTENANCE_FRONTEND, false)) {
            abort(503, 'The site is under maintenance');
        }
        return $next($request);
    }
}
