<div class="px-10 py-8 mb-8 bg-white rounded">
    <h1 class="text-xl font-bold mb-2">Industry Solutions</h1>
    <ul class="text-gray-600 divide-y">
        <li class="font-semibold">
            <a href="{{ route('landing.retail-consumer') }}" class="hover:text-green-500 leading-10{{ request()->routeIs('landing.retail-consumer') ? ' text-green-500' : '' }}">Retail & Customer</a>
        </li>
        <li class="font-semibold">
            <a href="{{ route('landing.science-healthcare') }}" class="hover:text-green-500 leading-10{{ request()->routeIs('landing.science-healthcare') ? ' text-green-500' : '' }}">Science & Healthcare</a>
        </li>
        <li class="font-semibold">
            <a href="{{ route('landing.industrial-chemical') }}" class="hover:text-green-500 leading-10{{ request()->routeIs('landing.industrial-chemical') ? ' text-green-500' : '' }}">Industrial & Chemical</a>
        </li>
        <li class="font-semibold">
            <a href="{{ route('landing.power-generation') }}" class="hover:text-green-500 leading-10{{ request()->routeIs('landing.power-generation') ? ' text-green-500' : '' }}">Power Generator</a>
        </li>
        <li class="font-semibold">
            <a href="{{ route('landing.food-beverage') }}" class="hover:text-green-500 leading-10{{ request()->routeIs('landing.food-beverage') ? ' text-green-500' : '' }}">Food & Beverage</a>
        </li>
        <li class="font-semibold">
            <a href="{{ route('landing.oil-gas') }}" class="hover:text-green-500 leading-10{{ request()->routeIs('landing.oil-gas') ? ' text-green-500' : '' }}">Oil & Gas</a>
        </li>
    </ul>
</div>
