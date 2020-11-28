<?php

namespace App\Exceptions;

use App\Models\Setting;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        // When we've got non-matched route resulting in "404 Not Found" response.
        if ($e instanceof NotFoundHttpException) {
            $config = app('config');
            $defaultLocale = app_setting(Setting::APP_LANGUAGE, $config['app.locale']);
            $locale = $request->segment(1);

            // See if locale in url is absent or isn't among known languages.
            if (!in_array($locale, ['id', 'en'])) {

                // get locale from referer
                $referer = $request->headers->get('referer');
                if (!empty($referer)) {
                    $refererPath = Arr::get(parse_url($referer), 'path', '');
                    $refererSegments = array_filter(explode('/', $refererPath), function ($value) {
                        return $value !== '';
                    });
                    $localeFromReferer = Arr::get(array_values($refererSegments), 0);
                    if (in_array($localeFromReferer, ['id', 'en'])) {
                        $defaultLocale = $localeFromReferer;
                    }
                }

                // Redirect to same url with default locale prepended.
                $uri = $request->getUriForPath('/' . $defaultLocale . $request->getPathInfo());

                return redirect($uri, 301);
            }
        }

        return parent::render($request, $e);
    }
}
