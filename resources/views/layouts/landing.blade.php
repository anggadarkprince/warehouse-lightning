<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#48bb78">
    <meta name="description" content="{{ app_setting('app-description') }}">
    <meta name="keywords" content="{{ app_setting('app-keywords') }}">
    <meta name="author" content="{{ app_setting('app-title') }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;900&display=swap" rel="stylesheet">

    <!-- Icon -->
    <link rel="icon" href="<?= url('img/favicon.png') ?>" type="image/x-icon">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/icon.css') }}" rel="stylesheet">
</head>
<body class="antialiased" style="background: #fdfdfd">
    <div class="px-4 max-w-6xl mx-auto">
        <header class="relative py-4">
            <div class="absolute mx-auto bg-white" style="left: 50%; transform: translateX(-50%)">
                <ul class="flex flex-col md:flex-row content-center">
                    <li class="py-2{{ request()->routeIs('welcome') ? ' border-b-2 border-green-500 text-green-500 font-bold' : '' }}">
                        <a href="{{ route('welcome') }}" class="px-3 hover:text-green-600">Home</a>
                    </li>
                    <li class="py-2{{ request()->routeIs('landing.solution') ? ' border-b-2 border-green-500 text-green-500 font-bold' : '' }}">
                        <a href="{{ route('landing.solution') }}" class="px-3 hover:text-green-600">Solution</a>
                    </li>
                    <li class="py-2{{ request()->routeIs('landing.use-case') ? ' border-b-2 border-green-500 text-green-500 font-bold' : '' }}">
                        <a href="{{ route('landing.use-case') }}" class="px-3 hover:text-green-600">Use Case</a>
                    </li>
                    <li class="py-2{{ request()->routeIs('landing.features') ? ' border-b-2 border-green-500 text-green-500 font-bold' : '' }}">
                        <a href="{{ route('landing.features') }}" class="px-3 hover:text-green-600">Features</a>
                    </li>
                    <li class="py-2{{ request()->routeIs('landing.contact') ? ' border-b-2 border-green-500 text-green-500 font-bold' : '' }}">
                        <a href="{{ route('landing.contact') }}" class="px-3 hover:text-green-600">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center mr-5">
                    <img src="<?= url('img/favicon.png') ?>" alt="Logo" class="mr-2 w-8">
                    <h1 class="font-bold text-lg">Warehouse</h1>
                </div>
                <div class="flex items-center pl-3">
                    <button class="px-2 mr-2 text-lg">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                    <div class="dropdown mr-5">
                        <button class="dropdown-toggle uppercase text-sm">
                            {{ str_replace('_', '-', app()->getLocale()) }}<i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ request()->getUriForPath('/en' . substr(request()->getPathInfo(), 3)) }}" class="dropdown-item">
                                English
                            </a>
                            <a href="{{ request()->getUriForPath('/id' . substr(request()->getPathInfo(), 3)) }}" class="dropdown-item">
                                Indonesia
                            </a>
                        </div>
                    </div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="button-primary">{{ __('Dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}">{{ __('Login') }}</a>

                        @if (app_setting(\App\Models\Setting::MANAGEMENT_REGISTRATION, true))
                            <a href="{{ route('register') }}" class="button-primary ml-4">{{ __('Register') }}</a>
                        @endif
                    @endif
                </div>
            </div>
        </header>
    </div>

    @yield('content')

    <footer>
        <div class="px-4 py-16 max-w-6xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <div class="col-span-2 text-gray-600">
                    <img src="<?= url('img/favicon.png') ?>" alt="Logo" class="mb-3 w-12">
                    <p class="text-sm mb-6 md:mr-10">
                        Our global logistics expertise, advanced supply chain technology & customized logistic
                        solutions will help you develop and implement successful supply.
                    </p>
                    <ul class="text-sm mb-4">
                        <li>
                            <span>Email:</span>
                            <a href="mailto:anggadarkprince@gmail.com" class="text-black hover:text-green-500">anggadarkprince@gmail.com</a>
                        </li>
                        <li>
                            <span>Phone:</span>
                            <a href="tel:+6285655479868" class="text-black hover:text-green-500">+6285655479868</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-5">Who We Are</h3>
                    <ul class="text-gray-600">
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">About Us</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Meet Our Team</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">News & Media</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Case Studies</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Contacts</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Careers</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-5">What We Do</h3>
                    <ul class="text-gray-600">
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Warehousing</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Air Freight</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Ocean Freight</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Road Freight</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Supply Chain</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Packaging</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-5">Who We Serve</h3>
                    <ul class="text-gray-600">
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Retail & Customer</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Science & Healthcare</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Industrial & Chemical</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Power Generator</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Food & Beverage</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Oil & Gas</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-5">Quick Links</h3>
                    <ul class="text-gray-600">
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Request A Quote</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Track & Trace</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Find A Location</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Global Agent</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-green-500 leading-loose">Help & FAQ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200">
            <div class="text-gray-600 px-4 py-6 max-w-6xl mx-auto sm:flex justify-between">
                <p>
                    &copy; {{ date('Y') }} Warehouse.app, with love by
                    <a href="https://angga-ari.com" class="text-green-500">angga-ari.com</a>
                </p>
                <ul>
                    <li class="inline-block"><a href="{{ route('legals.agreement') }}" class="hover:text-green-500">Terms & Condition</a></li>
                    <li class="inline-block"><i class="mdi mdi-circle-small"></i></li>
                    <li class="inline-block"><a href="{{ route('legals.privacy') }}" class="hover:text-green-500">Privacy Policy</a></li>
                    <li class="inline-block"><i class="mdi mdi-circle-small"></i></li>
                    <li class="inline-block"><a href="{{ url('sitemap.xml') }}" class="hover:text-green-500">Site Map</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
