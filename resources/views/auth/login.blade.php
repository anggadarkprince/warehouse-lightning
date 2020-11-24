@extends('layouts.auth')

@section('content')
    <div class="sm:container sm:mx-auto sm:max-w-md sm:my-10">

        @if (session('status'))
            <div class="alert-green" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="bg-white sm:border-1 sm:rounded-md sm:shadow-lg">

            <header class="text-center text-2xl bg-gray-200 text-gray-700 py-5 px-6 sm:rounded-t-md">
                {{ __('Sign In') }}
            </header>

            <form class="px-5 space-y-4 sm:px-10" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="flex flex-wrap">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email"  class="form-input @error('email') border-red-500 @enderror"
                           placeholder="Your email" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-wrap">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" placeholder="Password"
                           class="form-input @error('password') border-red-500 @enderror" name="password" required>
                    @error('password') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center py-2">
                    <label class="inline-flex items-center text-sm text-gray-700" for="remember">
                        <input type="checkbox" name="remember" id="remember" class="form-checkbox"
                            {{ old('remember') ? 'checked' : '' }}>
                        <span class="ml-2">{{ __('Remember Me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-link text-sm whitespace-no-wrap ml-auto"
                           href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>

                <div class="flex flex-wrap">
                    <button type="submit" class="button-primary button-lg w-full">
                        {{ __('Login') }}
                    </button>

                    <div class="w-full text-center text-gray-700 mt-5 mb-8 sm:text-sm">
                        @if (Route::has('register') && app_setting(\App\Models\Setting::MANAGEMENT_REGISTRATION, true))
                            {{ __("Don't have an account?") }}
                            <a class="text-link" href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>

                            <div class="sm:flex -mx-2 mt-4">
                                <div class="px-2 sm:w-1/2">
                                    <a href="{{ route('login.google') }}" class="button-blue w-full" style="background-color: #4285f4">
                                        <i class="mdi mdi-google mr-2"></i>Sign In Google
                                    </a>
                                </div>
                                <div class="px-2 sm:w-1/2">
                                    <a href="{{ route('login.google') }}" class="button-blue w-full" style="background-color: #00acee">
                                        <i class="mdi mdi-twitter mr-2"></i>Sign In Twitter
                                    </a>
                                </div>
                            </div>
                        @else
                            &copy {{ date('Y') }} Copyright all rights reserved
                        @endif
                    </p>
                </div>
            </form>

        </section>
    </div>
@endsection
