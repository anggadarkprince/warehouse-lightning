<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Base Url -->
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="theme-color" content="#48bb78">

    <title>{{ config('app.name', app_setting('app-title')) }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

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
</div>
</body>
</html>
