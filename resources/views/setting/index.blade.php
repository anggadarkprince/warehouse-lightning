@extends('layouts.app')

@section('content')
    <form action="{{ route('settings') }}" method="post" id="form-setting">
        @csrf
        @method('put')
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="sm:flex -mx-2 mb-4">
                <div class="px-2 md:w-1/4">
                    <h1 class="text-xl text-green-500">Basic Setting</h1>
                    <span class="text-gray-400 block mb-3">Application information</span>
                </div>
                <div class="px-2 md:w-2/3">
                    <div class="sm:flex -mx-2">
                        <div class="px-2 lg:w-5/12">
                            <div class="flex flex-wrap mb-3 sm:mb-4">
                                <label for="app-title" class="form-label">{{ __('Application Title') }}</label>
                                <input id="app-title" type="text" class="form-input @error('app-title') border-red-500 @enderror"
                                       name="app-title" value="{{ old('app-title', app_setting('app-title', config('app.name'))) }}"
                                       required placeholder="Application public name">
                                @error('app-title') <p class="form-text-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="px-2 lg:w-7/12">
                            <div class="flex flex-wrap mb-3 sm:mb-4">
                                <label for="app-tagline" class="form-label">{{ __('Tagline') }}</label>
                                <input id="app-tagline" type="text" class="form-input @error('app-tagline') border-red-500 @enderror"
                                       name="app-tagline" value="{{ old('app-tagline', app_setting('app-tagline')) }}"
                                       required placeholder="Explain what this site is about">
                                @error('app-tagline') <p class="form-text-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-3 sm:mb-4">
                        <label for="app-description" class="form-label">{{ __('Description') }}</label>
                        <textarea id="app-description" class="form-input @error('app-description') border-red-500 @enderror" name="app-description"
                                  required placeholder="Describe about the site">{{ old('app-description', app_setting('app-description')) }}</textarea>
                        @error('app-description') <p class="form-text-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex flex-wrap">
                        <label for="app-keywords" class="form-label">{{ __('Keywords') }}</label>
                        <input id="app-keywords" type="text" class="form-input @error('app-keywords') border-red-500 @enderror"
                               name="app-keywords" value="{{ old('app-keywords', app_setting('app-keywords')) }}"
                               required placeholder="Keyword about the site">
                        @error('app-keywords') <p class="form-text-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="sm:flex -mx-2">
                <div class="px-2 md:w-1/4">
                    <h1 class="text-xl text-green-500">Language</h1>
                    <span class="text-gray-400 block mb-3">Site language</span>
                </div>
                <div class="px-2 md:w-2/3">
                    <div class="flex flex-wrap mb-2">
                        <label for="app-language" class="form-label">{{ __('Default Language') }}</label>
                        <div class="relative w-full">
                            <select class="form-input pr-8" name="app-language" id="app-language">
                                <?php
                                $supportedLanguages = [
                                    'en' => 'English',
                                    'id' => 'Indonesia',
                                ]
                                ?>
                                @foreach($supportedLanguages as $lang => $language)
                                    <option value="{{ $lang }}"{{ old('app-language', app_setting('app-language', 'en')) == $lang ? ' selected' : '' }}>
                                        ({{ strtoupper($lang) }}) {{ $language }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                        @error('app-language') <p class="form-text-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="sm:flex -mx-2">
                <div class="px-2 md:w-1/4">
                    <h1 class="text-xl text-green-500">User Access</h1>
                    <span class="text-gray-400 block mb-3">Default role permission</span>
                </div>
                <div class="px-2 md:w-2/3">
                    <div class="flex flex-wrap mb-2">
                        <label for="default-management-group" class="form-label mb-2">{{ __('Default Role') }}</label>
                        <div class="w-full mb-3">
                            <label class="items-center text-gray-700 mt-2" for="management-registration">
                                <input type="checkbox" name="management-registration" id="management-registration" class="form-checkbox"
                                    {{ old('management-registration', app_setting('management-registration')) ? 'checked' : '' }}>
                                <span class="ml-2">{{ __('Allow public registration for management user') }}</span>
                            </label>
                            @error('management-registration') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="relative w-full">
                            <select class="form-input pr-8 disabled:opacity-75 disabled:text-gray-500" name="default-management-group" id="default-management-group">
                                <option value="">No Default Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"{{ old('default-management-group', app_setting('default-management-group')) == $role->id ? ' selected' : '' }}>
                                        {{ $role->role }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                        <span class="text-gray-400 text-sm mt-2">{{ __('When user register via public feature, automatically attached with this single group') }}</span>
                        @error('default-management-group') <p class="form-text-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="sm:flex -mx-2">
                <div class="px-2 md:w-1/4">
                    <h1 class="text-xl text-green-500">Emails</h1>
                    <span class="text-gray-400 block mb-3">Application emails</span>
                </div>
                <div class="px-2 md:w-2/3">
                    <div class="sm:flex -mx-2">
                        <div class="px-2 sm:w-1/2">
                            <div class="flex flex-wrap mb-3 sm:mb-4">
                                <label for="email-support" class="form-label">{{ __('Email Support') }}</label>
                                <input id="email-support" type="email" class="form-input @error('email-support') border-red-500 @enderror"
                                       placeholder="Email for contact support" name="email-support" value="{{ old('email-support', app_setting('email-support')) }}">
                                @error('email-support') <p class="form-text-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="px-2 sm:w-1/2">
                            <div class="flex flex-wrap mb-3 sm:mb-4">
                                <label for="email-bug-report" class="form-label">{{ __('Email Bug Report') }}</label>
                                <input id="email-bug-report" type="email" class="form-input @error('email-bug-report') border-red-500 @enderror"
                                       placeholder="Email for bug report" name="email-bug-report" value="{{ old('email-bug-report', app_setting('email-bug-report')) }}">
                                @error('email-bug-report') <p class="form-text-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="sm:flex -mx-2">
                <div class="px-2 md:w-1/4">
                    <h1 class="text-xl text-green-500">Maintenance</h1>
                    <span class="text-gray-400 block mb-3">Activate maintenance site</span>
                </div>
                <div class="px-2 md:w-2/3">
                    <div class="flex flex-wrap mb-3 sm:mb-4">
                        <label class="inline-flex items-center text-gray-700 mt-2" for="maintenance-frontend">
                            <input type="checkbox" name="maintenance-frontend" id="maintenance-frontend" class="form-checkbox"
                                {{ old('maintenance-frontend', app_setting('maintenance-frontend')) ? 'checked' : '' }}>
                            <span class="ml-2">{{ __('Activate maintenance mode front-end sites') }}</span>
                        </label>
                        <span class="ml-5 text-gray-400 text-sm">{{ __('When maintenance mode active, all critical request will be blocked') }}</span>
                        @error('maintenance-frontend') <p class="form-text-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 text-right">
            <button type="submit" class="button-primary w-full sm:w-auto">{{ __('Update') }} {{ __('Setting') }}</button>
        </div>
    </form>
@endsection
