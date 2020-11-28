<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->checkLocalePrefix();

        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::prefix('{locale}')
                ->middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure prefix locale.
     *
     * @return void
     */
    protected function checkLocalePrefix()
    {
        // Specify available languages for routes, set constraint rule.
        Route::pattern('locale', implode('|', ['id', 'en']));

        Route::matched(function (RouteMatched $event) {
            // Get language from route.
            $defaultLanguage = app_setting(Setting::APP_LANGUAGE, config('app.locale'));
            $locale = $event->route->parameter('locale', $defaultLanguage);

            // Ensure, that all built urls would have "locale" parameter set from url.
            url()->defaults(['locale' => $locale]);

            // Change application locale.
            app()->setLocale($locale);

            // Forget locale in route segment so parameter does not read in the controller
            \request()->route()->forgetParameter('locale');
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
