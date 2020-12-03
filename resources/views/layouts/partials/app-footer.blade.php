<footer class="px-4 py-5 border-t mt-3 text-sm text-gray-600">
    <div class="sm:flex content-center justify-between">
        <span class="text-muted text-center sm:text-left">
            {{ __('Copyright') }} &copy; {{ date('Y') }} <a href="{{ config('app.url') }}" target="_blank" class="font-bold">{{ config('app.name') }}</a>
            <span class="hidden sm:inline-block">{{ __('all rights reserved') }}.</span>
        </span>
        <div>
            <ul class="inline-block list-none">
                <li class="inline-block" title="Language"><i class="mdi mdi-earth text-fade"></i></li>
                <li class="inline-block">
                    <a href="{{ request()->getUriForPath('/en' . substr(request()->getPathInfo(), 3)) }}">
                        English
                    </a>
                </li>
                <li class="inline-block border-r mr-2">
                    &nbsp;
                </li>
                <li class="inline-block">
                    <a href="{{ request()->getUriForPath('/id' . substr(request()->getPathInfo(), 3)) }}">
                        Indonesia
                    </a>
                </li>
            </ul>
            <i class="mdi mdi-circle-medium inline-block mx-2"></i>
            <span class="text-center">
                {{ __('Made with') }} <i class="mdi mdi-heart text-red-400"></i>
            </span>
        </div>
    </div>
</footer>
