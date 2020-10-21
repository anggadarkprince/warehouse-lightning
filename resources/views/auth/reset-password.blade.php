@extends('layouts.auth')

@section('content')
    <div class="sm:container sm:mx-auto sm:max-w-md sm:my-10">
        <section class="bg-white sm:border-1 sm:rounded-md sm:shadow-lg">
            <header class="text-center text-2xl bg-gray-200 text-gray-700 py-5 px-6 sm:rounded-t-md">
                {{ __('Reset Password') }}
            </header>

            <form class="px-5 space-y-4 sm:px-10" method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="flex flex-wrap">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" readonly
                           class="form-input @error('email') border-red-500 @enderror" name="email"
                           value="{{ $email ?? old('email') }}" required autocomplete="email" placeholder="Email address">
                    @error('email') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-wrap">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" autofocus
                           class="form-input w-full @error('password') border-red-500 @enderror" name="password"
                           required autocomplete="new-password" placeholder="New password">
                    @error('password') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-wrap">
                    <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-input w-full"
                           name="password_confirmation" required autocomplete="new-password" placeholder="Repeat the password">
                </div>

                <div class="flex flex-wrap pt-3">
                    <button type="submit" class="button-primary button-lg w-full">
                        {{ __('Reset Password') }}
                    </button>
                    <p class="w-full block text-center text-gray-700 mt-6 mb-8 sm:text-sm">
                        {{ __('Remember password?') }}
                        <a class="text-link" href="{{ route('login') }}">
                            {{ __('Back to login') }}
                        </a>
                    </p>
                </div>
            </form>
        </section>
    </div>
@endsection
