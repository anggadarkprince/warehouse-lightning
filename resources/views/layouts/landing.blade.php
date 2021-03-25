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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;900&display=swap" rel="stylesheet">

    <!-- Icon -->
    <link rel="icon" href="<?= url('img/favicon.png') ?>" type="image/x-icon">

    <!-- Styles -->
    <link href="{{ mix('css/landing.css') }}" rel="stylesheet">
    <link href="{{ mix('css/icon.css') }}" rel="stylesheet">
</head>
<body class="antialiased" style="background: #fdfdfd">
    <div class="bg-white w-full transition-all duration-500 z-50" id="landing-header">
        <div class="px-4 max-w-6xl mx-auto">
            <header class="relative py-4">
                <div class="absolute mx-auto" style="left: 50%; transform: translateX(-50%)">
                    <ul class="flex flex-col md:flex-row content-center">
                        <li class="py-2 font-bold{{ request()->routeIs('welcome') ? ' border-b-2 border-green-500 text-green-500' : '' }}">
                            <a href="{{ route('welcome') }}" class="px-3 hover:text-green-600">Home</a>
                        </li>
                        <li class="py-2 font-bold{{ request()->routeIs('landing.solution') ? ' border-b-2 border-green-500 text-green-500' : '' }}">
                            <a href="{{ route('landing.solution') }}" class="px-3 hover:text-green-600">Solution</a>
                        </li>
                        <li class="py-2 font-bold{{ request()->routeIs('landing.use-case') ? ' border-b-2 border-green-500 text-green-500' : '' }}">
                            <a href="{{ route('landing.use-case') }}" class="px-3 hover:text-green-600">Use Case</a>
                        </li>
                        <li class="py-2 font-bold{{ request()->routeIs('landing.features') ? ' border-b-2 border-green-500 text-green-500' : '' }}">
                            <a href="{{ route('landing.features') }}" class="px-3 hover:text-green-600">Features</a>
                        </li>
                        <li class="py-2 font-bold{{ request()->routeIs('landing.contact') ? ' border-b-2 border-green-500 text-green-500' : '' }}">
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
                            <a href="{{ route('landing.warehousing') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.warehousing') ? ' text-green-500' : '' }}">
                                Warehousing
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.air-freight') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.air-freight') ? ' text-green-500' : '' }}">
                                Air Freight
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.ocean-freight') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.ocean-freight') ? ' text-green-500' : '' }}">
                                Ocean Freight
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.road-freight') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.road-freight') ? ' text-green-500' : '' }}">
                                Road Freight
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.supply-chain') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.supply-chain') ? ' text-green-500' : '' }}">
                                Supply Chain
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.packaging') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.packaging') ? ' text-green-500' : '' }}">
                                Packaging
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-5">Who We Serve</h3>
                    <ul class="text-gray-600">
                        <li>
                            <a href="{{ route('landing.retail-consumer') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.retail-consumer') ? ' text-green-500' : '' }}">
                                Retail & Customer
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.science-healthcare') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.science-healthcare') ? ' text-green-500' : '' }}">
                                Science & Healthcare
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.industrial-chemical') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.industrial-chemical') ? ' text-green-500' : '' }}">
                                Industrial & Chemical
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.power-generation') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.power-generation') ? ' text-green-500' : '' }}">
                                Power Generator
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.food-beverage') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.food-beverage') ? ' text-green-500' : '' }}">
                                Food & Beverage
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.oil-gas') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.oil-gas') ? ' text-green-500' : '' }}">
                                Oil & Gas
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-5">Quick Links</h3>
                    <ul class="text-gray-600">
                        <li>
                            <a href="{{ route('landing.request-quote') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.request-quote') ? ' text-green-500' : '' }}">
                                Request A Quote
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.track-trace') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.track-trace') ? ' text-green-500' : '' }}">
                                Track & Trace
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.find-location') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.find-location') ? ' text-green-500' : '' }}">
                                Find A Location
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.agent') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.agent') ? ' text-green-500' : '' }}">
                                Global Agent
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.faq') }}" class="hover:text-green-500 leading-loose{{ request()->routeIs('landing.faq') ? ' text-green-500' : '' }}">
                                Help & FAQ
                            </a>
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
