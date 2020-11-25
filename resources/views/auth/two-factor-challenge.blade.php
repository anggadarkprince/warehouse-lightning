@extends('layouts.auth')

@section('content')
    <div class="sm:container sm:mx-auto sm:max-w-md sm:my-10">

        @if (session('status'))
            <div class="alert-green" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="bg-white sm:border-1 sm:rounded-md sm:shadow-lg">

            <header class="text-center text-2xl bg-red-100 text-red-500 py-5 px-6 sm:rounded-t-md">
                <i class="mdi mdi-shield-account-outline mr-3"></i>{{ __('Two Factor Challenge') }}
            </header>

            <form class="px-5 space-y-4 sm:px-10" method="POST" action="{{ url('two-factor-challenge') }}">
                @csrf

                <p class="leading-normal text-gray-500">
                    {{ __('Enter one time password to continue login to your account.') }}
                </p>

                <div class="flex flex-wrap">
                    <input id="code" type="text" class="form-input @error('code') border-red-500 @enderror" name="code"
                           required autocomplete="code" placeholder="Enter OTP code">
                    @error('code') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-wrap justify-center items-center space-y-6 pb-6 sm:pb-10 sm:space-y-0 sm:justify-between">
                    <button type="submit" class="button-primary w-full sm:w-auto sm:order-1">
                        {{ __('Submit Code') }}
                    </button>
                    <a href="#" class="text-link"
                       onclick="event.preventDefault(); document.getElementById('recovery-wrapper').classList.remove('hidden');">
                        Use recovery code instead?
                    </a>
                </div>
            </form>

            <div class="hidden" id="recovery-wrapper">
                <hr class="mb-5">

                <form class="px-5 sm:px-10" method="POST" action="{{ url('two-factor-challenge') }}">
                    @csrf

                    <h3 class="text-xl text-green-500 font-bold">Recovery Code</h3>
                    <p class="text-gray-500 mb-2">
                        {{ __('Or enter recovery code if you difficult to acquire the OTP code.') }}
                    </p>

                    <div class="flex flex-wrap mb-4">
                        <input id="recovery_code" type="text" class="form-input @error('recovery_code') border-red-500 @enderror" name="recovery_code"
                               required autocomplete="recovery_code" placeholder="Enter recovery code">
                        @error('recovery_code') <p class="form-text-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="pb-6 sm:pb-10 text-right">
                        <button type="submit" class="button-red w-full sm:w-auto sm:order-1">
                            {{ __('Submit Using Recovery') }}
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
