<div class="flex items-center px-4 py-2 bg-green-500 text-white sm:h-16">
    <i class="mdi mdi-menu text-2xl py-1 cursor-pointer sidebar-toggle"></i>
    <div class="ml-4 opacity-50 flex items-center select-none{{ empty(request()->get('q')) ? '' : ' hidden' }}" id="search-placeholder">
        <i class="mdi mdi-magnify text-xl mr-1"></i>
        <span class="hidden sm:inline-block">Search over the app...</span>
    </div>
    <form action="{{ route('search') }}" class="flex flex-grow w-auto">
        <input type="search" name="q" class="form-input border-none rounded-full ml-4 transition-all duration-500 ease-in-out max-w-sm opacity-0 {{ empty(request()->get('q')) ? ' hidden' : ' max-w-md opacity-100' }}" id="input-navbar-search"
               value="{{ request()->get('q') }}" placeholder="Search over the app..." aria-label="Search">
    </form>
    <ul class="list-none ml-auto">
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
