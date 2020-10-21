@extends('layouts.app')

@section('content')
    <div class="sm:container sm:mx-auto sm:max-w-md sm:my-10">
        <section class="bg-white sm:border-1 sm:rounded-md sm:shadow-lg">
            <header class="text-center text-2xl bg-green-100 text-green-500 py-5 px-6 sm:rounded-t-md">
                <i class="mdi mdi-shield-account-outline mr-3"></i>{{ __('Confirm Password') }}
            </header>

            <form class="px-5 space-y-5 sm:px-10" method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <p class="leading-normal text-gray-500">
                    {{ __('Please confirm your password before continuing.') }}
                </p>

                <div class="flex flex-wrap">
                    <input id="password" type="password" class="form-input @error('password') border-red-500 @enderror" name="password"
                           required autocomplete="new-password" placeholder="Your password">
                    @error('password') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-wrap justify-center items-center space-y-6 pb-6 sm:pb-10 sm:space-y-0 sm:justify-between">
                    <button type="submit" class="button-primary w-full sm:w-auto sm:order-1">
                        {{ __('Confirm Password') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="mt-4 text-link text-xs sm:text-sm sm:order-0 sm:m-0"
                           href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>

        </section>
    </div>
@endsection
