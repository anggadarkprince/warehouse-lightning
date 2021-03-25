<div class="px-10 py-8 mb-8 bg-white rounded">
    <h1 class="text-xl font-bold mb-2">Service Offer</h1>
    <ul class="text-gray-600 divide-y">
        <li class="font-semibold">
            <a href="{{ route('landing.warehousing') }}" class="hover:text-green-500 leading-10{{ request()->routeIs('landing.warehousing') ? ' text-green-500' : '' }}">
                Warehousing
            </a>
        </li>
        <li class="font-semibold">
            <a href="{{ route('landing.air-freight') }}" class="hover:text-green-500 leading-10{{ request()->routeIs('landing.air-freight') ? ' text-green-500' : '' }}">
                Air Freight
            </a>
        </li>
        <li class="font-semibold">
            <a href="{{ route('landing.ocean-freight') }}" class="hover:text-green-500 leading-10{{ request()->routeIs('landing.ocean-freight') ? ' text-green-500' : '' }}">
                Ocean Freight
            </a>
        </li>
        <li class="font-semibold">
            <a href="{{ route('landing.road-freight') }}" class="hover:text-green-500 leading-10{{ request()->routeIs('landing.road-freight') ? ' text-green-500' : '' }}">
                Road Freight
            </a>
        </li>
        <li class="font-semibold">
            <a href="{{ route('landing.supply-chain') }}" class="hover:text-green-500 leading-10{{ request()->routeIs('landing.supply-chain') ? ' text-green-500' : '' }}">
                Supply Chain
            </a>
        </li>
        <li class="font-semibold">
            <a href="{{ route('landing.packaging') }}" class="hover:text-green-500 leading-10{{ request()->routeIs('landing.packaging') ? ' text-green-500' : '' }}">
                Packaging
            </a>
        </li>
    </ul>
</div>
