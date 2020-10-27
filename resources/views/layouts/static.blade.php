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
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Icon -->
    <link rel="icon" href="<?= url('img/favicon.png') ?>" type="image/x-icon">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/icon.css') }}" rel="stylesheet">
</head>
<body>
<div class="bg-gray-100">
    <header class="bg-white shadow-sm">
        <div class="py-4 px-5 mx-auto flex justify-between items-center sm:container lg:px-40">
            <div>
                <h1 class="text-lg font-bold text-green-500">
                    {{ config('app.name', app_setting('app-title')) }}
                </h1>
                <p class="text-gray-500 text-sm leading-tight">
                    {{ app_setting('app-tagline') }}
                </p>
            </div>
            <div class="text-gray-700">
                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    @if (Route::has('register') && app_setting(\App\Models\Setting::MANAGEMENT_REGISTRATION, true))
                        <a href="{{ route('register') }}" class="ml-4">Register</a>
                    @endif
                @endif
            </div>
        </div>
    </header>
    <main class="py-4 px-5 mx-auto sm:container lg:px-40" style="min-height: calc(100vh - 151px)">
        @yield('content')
    </main>
    <footer class="px-4 py-5 border-t mt-3 text-sm text-gray-600">
        <div class="mx-auto sm:container lg:px-40">
            <div class="sm:flex content-center justify-between">
                <div class="text-muted text-center sm:text-left">
                    Copyright &copy; {{ date('Y') }} <a href="{{ config('app.url') }}" target="_blank" class="font-bold hover:text-green-500">{{ config('app.name') }}</a>
                    <span class="hidden sm:inline-block">all rights reserved.</span>
                </div>
                <ul class="hidden text-center md:inline-block">
                    <li class="inline-block px-1"><a href="{{ route('welcome') }}" class="hover:text-green-500">Home</a></li>
                    <li class="inline-block px-1"><a href="{{ route('legals.index') }}" class="hover:text-green-500">Legals</a></li>
                    <li class="inline-block px-1"><a href="{{ route('legals.cookie') }}" class="hover:text-green-500">Cookie</a></li>
                    <li class="inline-block px-1"><a href="{{ route('legals.privacy') }}" class="hover:text-green-500">Privacy</a></li>
                    <li class="inline-block px-1"><a href="{{ route('legals.agreement') }}" class="hover:text-green-500">Agreement</a></li>
                    <li class="inline-block px-1"><a href="{{ route('legals.sla') }}" class="hover:text-green-500">SLA</a></li>
                </ul>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
