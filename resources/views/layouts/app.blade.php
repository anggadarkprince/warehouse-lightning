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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Icon -->
    <link rel="icon" href="<?= url('img/favicon.png') ?>" type="image/x-icon">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/icon.css') }}" rel="stylesheet">
</head>
<body class="antialiased">
<div class="flex bg-gray-100 text-gray-700" id="wrapper">
    <!-- Sidebar -->
    @include('layouts.partials.app-sidebar')

    <!-- Content -->
    <div id="content-wrapper" class="flex flex-col w-full min-h-screen h-full">
        <!-- Top navbar -->
        @include('layouts.partials.app-navbar')

        <!-- Main content -->
        <div class="sm:p-4 flex-grow">
            @if (session('status'))
                <div class="mb-3 {{ session('status') == 'success' ? 'alert-green' : ((session('status') == 'failed' || session('status') == 'error') ? 'alert-red' : 'alert-orange') }}" role="alert">
                    {{ session('message') ?: ucfirst(preg_replace('/(_|\-)/', ' ', session('status'))) }}
                </div>
            @endif

            @yield('content')
        </div>

        <!-- Footer -->
        @include('layouts.partials.app-footer')
    </div>
</div>

<!-- Scripts -->
@yield('libraries')
<script src="{{ mix('js/app.js') }}"></script>
@yield('scripts')

</body>
</html>
