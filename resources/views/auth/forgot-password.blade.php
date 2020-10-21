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
                {{ __('Reset Password') }}
            </header>

            <form class="px-5 space-y-4 sm:px-10" method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="flex flex-wrap">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-input @error('email') border-red-500 @enderror" name="email"
                           value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email address">
                    @error('email') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-wrap pt-3">
                    <button type="submit" class="button-primary button-lg w-full">
                        {{ __('Send Password Reset Link') }}
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
