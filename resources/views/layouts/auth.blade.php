<!doctype html>
<html lang="{{ str_replace('_', '-', app_setting('app-language', app()->getLocale())) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Base Url -->
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="theme-color" content="#48bb78">
    <meta name="description" content="{{ app_setting('app-description') }}">
    <meta name="keywords" content="{{ app_setting('app-keywords') }}">
    <meta name="author" content="{{ app_setting('app-title') }}">

    <title>{{ config('app.name', app_setting('app-title')) }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Icon -->
    <link rel="icon" href="<?= url('img/favicon.png') ?>" type="image/x-icon">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/icon.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <main>
        @yield('content')
    </main>
    <div class="text-center mb-5 md:mb-8">
        <ul class="inline-block list-none text-gray-500">
            <li class="inline-block" title="Language"><i class="mdi mdi-earth text-fade"></i></li>
            <li class="inline-block">
                <a href="{{ request()->getUriForPath('/en' . substr(request()->getPathInfo(), 3)) }}">
                    English
                </a>
            </li>
            <li class="inline-block border-r mr-2">
                &nbsp;
            </li>
            <li class="inline-block">
                <a href="{{ request()->getUriForPath('/id' . substr(request()->getPathInfo(), 3)) }}">
                    Indonesia
                </a>
            </li>
        </ul>
    </div>
</div>
</body>
</html>
