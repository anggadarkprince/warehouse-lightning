@extends('layouts.app')

@section('content')
    <form action="{{ route('user-profile-information.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="sm:flex -mx-2 mb-4">
                <div class="px-2 sm:w-1/4">
                    <h1 class="text-xl text-green-500">{{ __('User Information') }}</h1>
                    <p class="text-gray-400 leading-tight mb-3">Edit name and email</p>
                </div>
                <div class="px-2 sm:w-2/3">
                    <div class="sm:flex -mx-2">
                        <div class="px-2 sm:w-1/2">
                            <div class="flex flex-wrap">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-input @error('name') border-red-500 @enderror"
                                       name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" placeholder="Your full name">
                                <p class="form-text-error">{{ $errors->updateProfileInformation->first('name') }}</p>
                            </div>
                        </div>
                        <div class="px-2 sm:w-1/2">
                            <div class="flex flex-wrap">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-input @error('email') border-red-500 @enderror" name="email"
                                       value="{{ old('email', $user->email) }}" required autocomplete="email" placeholder="Email address">
                                <p class="form-text-error">{{ $errors->updateProfileInformation->first('email') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="sm:flex -mx-2">
                <div class="px-2 sm:w-1/4">
                    <h1 class="text-xl text-green-500">{{ __('Avatar') }}</h1>
                    <p class="text-gray-400 leading-tight mb-3">Change your photo</p>
                </div>
                <div class="px-2 sm:w-2/3">
                    <div class="sm:flex items-center input-file-wrapper text-center">
                        <div class="bg-gray-400 inline-block mr-4 mb-3 sm:mb-0 rounded-md flex-shrink-0">
                            <a href="{{ $user->avatar_url }}">
                                <img class="h-32 w-32 object-cover rounded-md" id="image-avatar" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                            </a>
                        </div>
                        <div class="flex w-full">
                            <input type="text" readonly class="form-input input-file-label rounded-tr-none rounded-br-none" placeholder="Pick new avatar" aria-label="Avatar">
                            <div class="relative">
                                <input class="input-file button-primary absolute block hidden top-0" data-target-preview="#image-avatar" type="file" name="avatar" id="avatar" accept="image/*">
                                <label for="avatar" class="button-choose-file button-primary py-2 px-4 rounded-tl-none rounded-bl-none border border-transparent cursor-pointer">
                                    Choose Image
                                </label>
                            </div>
                        </div>
                    </div>
                    <p class="form-text-error">{{ $errors->updateProfileInformation->first('avatar') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="sm:flex -mx-2">
                <div class="px-2 sm:w-1/4">
                    <h1 class="text-xl text-green-500">{{ __('Password') }}</h1>
                    <p class="text-gray-400 leading-tight mb-3">Change your password</p>
                </div>
                <div class="px-2 sm:w-2/3">
                    <div class="flex flex-wrap mb-3 sm:mb-4">
                        <label for="password" class="form-label">{{ __('New Password') }}</label>
                        <input id="password" type="password" class="form-input @error('password') border-red-500 @enderror"
                               name="password" value="{{ old('password') }}" placeholder="New password">
                        <p class="form-text-error">{{ $errors->updateProfileInformation->first('password') }}</p>
                    </div>
                    <div class="flex flex-wrap mb-3 sm:mb-4">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm New Password') }}</label>
                        <input id="password_confirmation" type="password" class="form-input @error('email') border-red-500 @enderror" name="password_confirmation"
                               value="{{ old('password_confirmation') }}" placeholder="Confirm new password">
                        <p class="form-text-error">{{ $errors->updateProfileInformation->first('password_confirmation') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="sm:flex -mx-2">
                <div class="px-2 sm:w-1/4">
                    <h1 class="text-xl text-green-500">{{ __('Two Factor Auth') }}</h1>
                    <p class="text-gray-400 leading-tight mb-3">Enhance your security</p>
                </div>
                <div class="px-2 sm:w-2/3">
                    <div class="mb-3 sm:mb-4">
                        <label for="password" class="form-label">{{ __('Two Factor Authentication') }}</label>
                        @if($user->two_factor_secret)
                            <div class="mb-4">
                                <p class="text-gray-500">
                                    <i class="mdi mdi-information-outline mr-1"></i>
                                    Please scan the following QR code into your phones authenticator application.
                                </p>
                                <p>
                                    Download Google Authenticator to obtain OTP code,
                                    for Android user <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" class="text-link">download here</a>
                                    and iPhone user <a href="https://apps.apple.com/us/app/google-authenticator/id388497605" class="text-link">download here</a>.
                                </p>
                            </div>
                            <div class="sm:flex mb-3">
                                <div class="mb-3 sm:mb-0 sm:mr-4 md:mr-5">
                                    {!! $user->twoFactorQrCodeSvg() !!}
                                    <div class="mt-3">
                                        <button type="button" class="button-red sm:w-full"
                                                onclick="event.preventDefault(); document.getElementById('disable-2fa-form').submit();">Disable 2FA</button>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-bold">Please store recovery codes in a secure location:</p>
                                    <p class="mb-2 text-gray-500 leading-tight">Remember these recovery code only can be use once and then it will be generated again.</p>
                                    <ul class="list-inside list-disc text-sm">
                                        @foreach(json_decode(decrypt($user->two_factor_recovery_codes), true) as $code)
                                            <li>{{ trim($code) }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @else
                            <p class="text-red-500 mb-3">
                                <i class="mdi mdi-alert-circle-outline mr-1"></i>You have not enable 2FA
                            </p>
                            <button type="button" class="button-blue"
                                    onclick="event.preventDefault(); document.getElementById('enable-2fa-form').submit();">Enable 2FA</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 text-right">
            <button type="submit" class="button-primary w-full sm:w-auto">{{ __('Update') }} {{ __('Account') }}</button>
        </div>
    </form>

    <form id="enable-2fa-form" action="{{ url('user/two-factor-authentication') }}" method="post">
        @csrf
    </form>
    <form id="disable-2fa-form" action="{{ url('user/two-factor-authentication') }}" method="post">
        @csrf
        @method('delete')
    </form>
@endsection
