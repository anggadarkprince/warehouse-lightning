@extends('layouts.auth')

@section('content')
    <div class="sm:container sm:mx-auto sm:max-w-lg sm:my-10">
        @if (session('resent'))
            <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100  px-3 py-4 mb-4"
                 role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <section class="bg-white sm:border-1 sm:rounded-md sm:shadow-lg">
            <header class="text-center text-2xl bg-gray-200 text-gray-700 py-5 px-6 sm:rounded-t-md">
                {{ __('Verify Your Email Address') }}
            </header>

            <div class="text-gray-700 leading-normal text-sm p-6 sm:text-base">
                <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                <p>
                    {{ __('If you did not receive the email') }},
                    <a class="text-link cursor-pointer" onclick="event.preventDefault(); document.getElementById('resend-verification-form').submit();">
                        {{ __('click here to request another') }}
                    </a>
                </p>

                <form id="resend-verification-form" method="POST" action="{{ route('verification.send') }}" class="hidden">
                    @csrf
                </form>
            </div>

        </section>
    </div>
@endsection
