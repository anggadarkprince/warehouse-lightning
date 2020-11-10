<div class="bg-white flex flex-col min-h-screen shadow-sm" id="sidebar-wrapper" style="transition: margin .15s ease-in-out;">
    <div class="px-4 py-2 bg-green-100 rounded-full mx-3 mt-3 text-center group">
        <a href="{{ route('dashboard') }}" class="text-green-500 flex items-center justify-center hover:text-green-600">
            <i class="mdi mdi-package-variant text-xl mr-1"></i>
            <span class="text-lg uppercase">{{ config('app.name') }}</span>
        </a>
    </div>
    <ul class="overflow-hidden list-none flex flex-col flex-auto pb-5" style="width: 245px">
        <li class="mt-2">
            <a href="{{ route('account') }}" class="flex items-center py-2 px-5 group">
                <img src="{{ url(auth()->user()->avatar) }}"
                     alt="avatar" class="rounded-full object-cover h-12 w-12 flex-shrink-0">
                <div class="flex flex-col truncate ml-3">
                    <p class="group-hover:text-green-500">{{ auth()->user()->name }}</p>
                    <small class="text-gray-500 text-opacity-75 truncate group-hover:text-gray-400">{{ auth()->user()->email }}</small>
                </div>
            </a>
        </li>

        <li class="flex items-center py-2 px-5 text-xs text-gray-400">
            {{ __('MAIN MENU') }} <i class="mdi mdi-arrow-right ml-auto"></i>
        </li>
        <li>
            <a class="flex items-center py-2 px-5 hover:bg-green-100{{ request()->is('dashboard') ? ' bg-green-100' : '' }}" href="{{ route('dashboard') }}">
                <i class="mdi mdi-speedometer mr-2"></i>
                {{ __('Dashboard') }}
            </a>
        </li>
        @if(request()->user()->can('view-any', \App\Models\Role::class) || request()->user()->can('view-any', \App\Models\User::class))
            <li>
                <a href="#submenu-user-access" class="flex items-center py-2 px-5 hover:bg-green-100 menu-toggle{{ request()->is('user-access*') ? ' bg-green-100' : ' collapsed' }}">
                    <i class="mdi mdi-lock-outline mr-2 pointer-events-none"></i>
                    {{ __('User Access') }}
                    <i class="mdi mdi-chevron-down ml-auto pointer-events-none menu-arrow"></i>
                </a>
                <div id="submenu-user-access" class="sidebar-submenu{{ request()->is('user-access*') ? '' : ' submenu-hide' }}">
                    <ul class="overflow-hidden flex flex-col pb-2">
                        @can('view-any', \App\Models\Role::class)
                            <li>
                                <a class="flex items-center py-1 pl-12 pr-5 hover:bg-green-100{{ request()->is('user-access/roles*') ? ' text-green-500' : '' }}" href="{{ route('roles.index') }}">
                                    <i class="mdi mdi-shield-account-outline mr-2"></i>
                                    {{ __('Roles') }}
                                </a>
                            </li>
                        @endcan
                        @can('view-any', \App\Models\User::class)
                            <li>
                                <a class="flex items-center py-1 pl-12 pr-5 hover:bg-green-100{{ request()->is('user-access/users*') ? ' text-green-500' : '' }}" href="{{ route('users.index') }}">
                                    <i class="mdi mdi-account-multiple-outline mr-2"></i>
                                    {{ __('Users') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endif

        @if(request()->user()->can('view-any', \App\Models\DocumentType::class)
            || request()->user()->can('view-any', \App\Models\BookingType::class)
            || request()->user()->can('view-any', \App\Models\Customer::class)
            || request()->user()->can('view-any', \App\Models\Container::class)
            || request()->user()->can('view-any', \App\Models\Goods::class))
            <li>
                <a href="#submenu-master" class="flex items-center py-2 px-5 hover:bg-green-100 menu-toggle{{ request()->is('master*') ? ' bg-green-100' : ' collapsed' }}">
                    <i class="mdi mdi-cube-outline mr-2 pointer-events-none"></i>
                    {{ __('Master') }}
                    <i class="mdi mdi-chevron-down ml-auto pointer-events-none menu-arrow"></i>
                </a>
                <div id="submenu-master" class="sidebar-submenu{{ request()->is('master*') ? '' : ' submenu-hide' }}">
                    <ul class="overflow-hidden flex flex-col pb-2">
                        @can('view-any', \App\Models\DocumentType::class)
                            <li>
                                <a class="flex items-center py-1 pl-12 pr-5 hover:bg-green-100{{ request()->is('master/document-types*') ? ' text-green-500' : '' }}" href="{{ route('document-types.index') }}">
                                    <i class="mdi mdi-file-document-outline mr-2"></i>
                                    {{ __('Document Types') }}
                                </a>
                            </li>
                        @endcan
                        @can('view-any', \App\Models\BookingType::class)
                            <li>
                                <a class="flex items-center py-1 pl-12 pr-5 hover:bg-green-100{{ request()->is('master/booking-types*') ? ' text-green-500' : '' }}" href="{{ route('booking-types.index') }}">
                                    <i class="mdi mdi-clipboard-outline mr-2"></i>
                                    {{ __('Booking Types') }}
                                </a>
                            </li>
                        @endcan
                        @can('view-any', \App\Models\Customer::class)
                            <li>
                                <a class="flex items-center py-1 pl-12 pr-5 hover:bg-green-100{{ request()->is('master/customers*') ? ' text-green-500' : '' }}" href="{{ route('customers.index') }}">
                                    <i class="mdi mdi-account-multiple-outline mr-2"></i>
                                    {{ __('Customers') }}
                                </a>
                            </li>
                        @endcan
                        @can('view-any', \App\Models\Container::class)
                            <li>
                                <a class="flex items-center py-1 pl-12 pr-5 hover:bg-green-100{{ request()->is('master/containers*') ? ' text-green-500' : '' }}" href="{{ route('containers.index') }}">
                                    <i class="mdi mdi-truck-outline mr-2"></i>
                                    {{ __('Containers') }}
                                </a>
                            </li>
                        @endcan
                        @can('view-any', \App\Models\Goods::class)
                            <li>
                                <a class="flex items-center py-1 pl-12 pr-5 hover:bg-green-100{{ request()->is('master/goods*') ? ' text-green-500' : '' }}" href="{{ route('goods.index') }}">
                                    <i class="mdi mdi-package-variant mr-2"></i>
                                    {{ __('Goods') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endif

        @can('view-any', \App\Models\Upload::class)
            <li>
                <a class="flex items-center py-2 px-5 hover:bg-green-100{{ request()->is('uploads*') ? ' text-green-500' : '' }}" href="{{ route('uploads.index') }}">
                    <i class="mdi mdi-folder-search-outline mr-2"></i>
                    {{ __('Documents') }}
                </a>
            </li>
        @endcan

        @can('view-any', \App\Models\Booking::class)
            <li>
                <a class="flex items-center py-2 px-5 hover:bg-green-100{{ request()->is('bookings*') ? ' text-green-500' : '' }}" href="{{ route('bookings.index') }}">
                    <i class="mdi mdi-clipboard-file-outline mr-2"></i>
                    {{ __('Bookings') }}
                </a>
            </li>
        @endcan

        @can('view-any', \App\Models\DeliveryOrder::class)
            <li>
                <a class="flex items-center py-2 px-5 hover:bg-green-100{{ request()->is('delivery-orders*') ? ' text-green-500' : '' }}" href="{{ route('delivery-orders.index') }}">
                    <i class="mdi mdi-truck-fast-outline mr-2"></i>
                    {{ __('Delivery Orders') }}
                </a>
            </li>
        @endcan

        <li>
            <a class="flex items-center py-2 px-5 hover:bg-green-100{{ request()->is('gate*') ? ' text-green-500' : '' }}" href="{{ route('gate.index') }}">
                <i class="mdi mdi-boom-gate-down-outline mr-2"></i>
                {{ __('Gate') }}
            </a>
        </li>

        <li>
            <a class="flex items-center py-2 px-5 hover:bg-green-100{{ request()->is('tally*') ? ' text-green-500' : '' }}" href="{{ route('tally.index') }}">
                <i class="mdi mdi-forklift mr-2"></i>
                {{ __('Tally') }}
            </a>
        </li>

        <li>
            <a class="flex items-center py-2 px-5 hover:bg-green-100{{ request()->is('take-stock*') ? ' text-green-500' : '' }}" href="/">
                <i class="mdi mdi-clipboard-pulse-outline mr-2"></i>
                {{ __('Take Stock') }}
            </a>
        </li>

        <li>
            <a href="#submenu-report" class="flex items-center py-2 px-5 hover:bg-green-100 menu-toggle{{ request()->is('reports*') ? ' bg-green-100' : ' collapsed' }}">
                <i class="mdi mdi-ballot-outline mr-2 pointer-events-none"></i>
                {{ __('Report') }}
                <i class="mdi mdi-chevron-down ml-auto pointer-events-none menu-arrow"></i>
            </a>
            <div id="submenu-report" class="sidebar-submenu{{ request()->is('reports*') ? '' : ' submenu-hide' }}">
                <ul class="overflow-hidden flex flex-col pb-2">
                    <li>
                        <a class="flex items-center py-1 pl-12 pr-5 hover:bg-green-100{{ request()->is('reports/inbound*') ? ' text-green-500' : '' }}" href="/">
                            <i class="mdi mdi-sort-bool-ascending mr-2"></i>
                            {{ __('Inbound') }}
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center py-1 pl-12 pr-5 hover:bg-green-100{{ request()->is('reports/outbound*') ? ' text-green-500' : '' }}" href="/">
                            <i class="mdi mdi-sort-bool-descending mr-2"></i>
                            {{ __('Outbound') }}
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center py-1 pl-12 pr-5 hover:bg-green-100{{ request()->is('reports/stock-summary*') ? ' text-green-500' : '' }}" href="/">
                            <i class="mdi mdi-clipboard-check-outline mr-2"></i>
                            {{ __('Stock Summary') }}
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center py-1 pl-12 pr-5 hover:bg-green-100{{ request()->is('reports/stock-movement*') ? ' text-green-500' : '' }}" href="/">
                            <i class="mdi mdi-clipboard-text-play-outline mr-2"></i>
                            {{ __('Stock Movement') }}
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="flex items-center py-2 px-5 text-xs text-gray-400">
            {{ __('PREFERENCES') }} <i class="mdi mdi-arrow-right ml-auto"></i>
        </li>
        @can('edit-account', \App\Models\User::class)
            <li>
                <a class="flex items-center py-2 px-5 hover:bg-green-100{{ request()->is('account') ? ' text-green-500' : '' }}" href="{{ route('account') }}">
                    <i class="mdi mdi-account-reactivate-outline mr-2"></i>
                    {{ __('Account') }}
                </a>
            </li>
        @endcan
        @can('edit-setting', \App\Models\Setting::class)
            <li>
                <a class="flex items-center py-2 px-5 hover:bg-green-100{{ request()->is('settings') ? ' text-green-500' : '' }}" href="{{ route('settings') }}">
                    <i class="mdi mdi-cog-outline mr-2"></i>
                    {{ __('Settings') }}
                </a>
            </li>
        @endcan
        @auth
            <li>
                <a class="flex items-center py-2 px-5 hover:bg-green-100 cursor-pointer"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="mdi mdi-logout-variant mr-2"></i>
                    {{ __('Sign out') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    {{ csrf_field() }}
                </form>
            </li>
        @else
            <li>
                <a class="flex items-center py-2 px-5 hover:bg-green-100" href="{{ route('login') }}">
                    <i class="mdi mdi-login-variant mr-2"></i>
                    {{ __('Login') }}
                </a>
            </li>

            @if (Route::has('register'))
                <li>
                    <a class="flex items-center py-2 px-5 hover:bg-green-100" href="{{ route('register') }}">
                        <i class="mdi mdi-account-plus-outline mr-2"></i>
                        {{ __('Register') }}
                    </a>
                </li>
            @endif
        @endauth
    </ul>
</div>
