<div class="flex items-center px-4 py-2 bg-green-500 text-white sm:h-16">
    <i class="mdi mdi-menu text-2xl py-1 cursor-pointer sidebar-toggle"></i>
    <div class="ml-4 opacity-50 flex items-center select-none{{ empty(request()->get('q')) ? '' : ' hidden' }}" id="search-placeholder">
        <i class="mdi mdi-magnify text-xl mr-1"></i>
        <span class="hidden sm:inline-block">Search over the app...</span>
    </div>
    <form action="{{ route('search') }}" class="flex flex-grow w-auto relative" id="search-navbar-form">
        <input type="search" name="q" class="form-input border-none rounded-full ml-4 transition-all duration-500 ease-in-out max-w-sm opacity-0 {{ empty(request()->get('q')) ? ' hidden' : ' max-w-md opacity-100' }}" id="input-navbar-search"
               value="{{ request()->get('q') }}" placeholder="Search over the app..." aria-label="Search" autocomplete="off">
        <div id="search-navbar-result" class="absolute py-3 mb-4 bg-white text-gray-700 shadow rounded mt-12 ml-3 hidden" style="min-width: 300px; max-width: 400px">
            <div id="search-navbar-loading" class="px-4">
                <i class="mdi mdi-loading mdi-spin mr-1"></i> searching data...
            </div>

            <div class="mb-2">
                <h3 class="flex justify-between bg-green-400 text-white px-4 py-2 mb-1 hidden" id="search-booking-title">
                    Booking Result<i class="mdi mdi-clipboard-file-outline"></i>
                </h3>
                <div id="search-booking-wrapper" class="divide-y"></div>
            </div>

            <div class="mb-2">
                <h3 class="flex justify-between bg-green-400 text-white px-4 py-2 mb-1 hidden" id="search-job-title">
                    Job Result<i class="mdi mdi-forklift ml-auto"></i>
                </h3>
                <div id="search-job-wrapper" class="divide-y"></div>
            </div>

            <div class="mb-2">
                <h3 class="flex justify-between bg-green-400 text-white px-4 py-2 mb-1 hidden" id="search-delivery-title">
                    Delivery Result<i class="mdi mdi-truck-fast-outline ml-auto"></i>
                </h3>
                <div id="search-delivery-wrapper" class="divide-y"></div>
            </div>

            <div class="px-4">
                <button type="submit" class="button-blue button-sm block w-full mt-4">
                    More result <i class="mdi mdi-arrow-right"></i>
                </button>
            </div>
            <img src="{{ asset('img/search-by-algolia-light-background.svg') }}" class="mx-auto mt-3 w-24" alt="Algolia">
        </div>
    </form>
    <ul class="list-none ml-auto">
        <li class="inline-block py-2 cursor-pointer leading-7 align-top">
            <div class="dropdown">
                <button class="dropdown-toggle">
                    <i class="mdi mdi-bell-outline px-3"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" style="min-width: 300px">
                    @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                        @if($notification->type == \App\Notifications\WorkOrderValidated::class)
                            <a href="{{ route('notifications.show', ['id' => $notification->id]) }}" class="dropdown-item" style="white-space: normal">
                                <div class="flex flex-row">
                                    <i class="text-2xl mdi mdi-file-check-outline mr-2 text-green-500"></i>
                                    <div>
                                        <p class="leading-tight">
                                            Job <span class="lowercase">{{ data_get($notification->data, 'job_type') }}</span>
                                            {{ data_get($notification->data, 'job_number') }} is validated
                                        </p>
                                        <p class="text-xs text-gray-500 leading-loose">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @empty
                        <p class="dropdown-item">No new notification available.</p>
                    @endforelse
                    <hr class="divide-gray-200">
                    <a href="{{ route('notifications.index') }}" class="flex justify-between px-4 pt-2 font-bold hover:text-green-500">
                        <p class="text-sm">View all notifications</p> <i class="mdi mdi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </li>
        <li class="inline-block py-2 px-3 cursor-pointer leading-7 align-top">
            <div class="dropdown">
                <button class="dropdown-toggle">
                    {{ auth()->user()->name }} <i class="mdi mdi-chevron-down"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('dashboard') }}" class="dropdown-item">
                        <i class="mdi mdi-speedometer mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('welcome') }}" class="dropdown-item">
                        <i class="mdi mdi-home-outline mr-2"></i>Back Home
                    </a>
                    @can('edit-account', \App\Models\User::class)
                        <a href="{{ route('account') }}" class="dropdown-item">
                            <i class="mdi mdi-account-outline mr-2"></i>Account
                        </a>
                    @endcan
                    @auth
                        <hr class="border-gray-200">
                        <a class="dropdown-item cursor-pointer" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="mdi mdi-logout-variant mr-2"></i>Sign Out
                        </a>
                    @endauth
                </div>
            </div>
        </li>
    </ul>
</div>

<script id="search-result-template" type="x-tmpl-mustache">
    <a href="@{{ url }}" class="py-2 px-4 flex justify-between hover:bg-green-100 booking-search-result">
        <div class="mr-3">
            <p class="font-bold">@{{ title }}</p>
            <p class="text-sm text-gray-500 leading-tight">@{{ subtitle }}</p>
            <p class="text-sm">@{{ description }}</p>
        </div>
        <div class="text-xs mt-1 @{{ label_color }}">
            @{{ label }}
        </div>
    </div>
</script>
