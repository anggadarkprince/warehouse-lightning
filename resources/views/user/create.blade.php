@extends('layouts.app')

@section('content')
    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Create User</h1>
                <span class="text-gray-400">Manage all user account</span>
            </div>
            <div class="pt-2">
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-input @error('name') border-red-500 @enderror"
                                   placeholder="User name" name="name" value="{{ old('name') }}">
                            @error('name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-input @error('email') border-red-500 @enderror"
                                   placeholder="Email address" name="email" value="{{ old('email') }}">
                            @error('email') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="sm:flex -mx-2">
                    <div class="w-full px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-input @error('password') border-red-500 @enderror"
                                   placeholder="New password" name="password" value="{{ old('password') }}">
                            @error('password') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="w-full px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" type="password" class="form-input @error('password_confirmation') border-red-500 @enderror"
                                   placeholder="Confirm the password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                            @error('password_confirmation') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-4">
                <h1 class="text-xl text-green-500">Avatar</h1>
                <span class="text-gray-400">Choose photo of user</span>
            </div>
            <div class="sm:flex items-center pb-3 input-file-wrapper">
                <div class="bg-gray-400 inline-block mr-4 mb-3 sm:mb-0 rounded-md flex-shrink-0">
                    <img class="object-cover h-32 w-32 rounded-md" id="image-avatar" src="{{ url('img/no-image.png') }}" alt="Avatar">
                </div>
                <div class="flex w-full">
                    <input type="text" readonly class="form-input input-file-label rounded-tr-none rounded-br-none" placeholder="Select avatar" aria-label="Avatar">
                    <div class="relative">
                        <input class="input-file button-primary absolute block hidden top-0" data-target-preview="#image-avatar" type="file" name="avatar" id="avatar" accept="image/*">
                        <label for="avatar" class="button-choose-file button-primary py-2 px-4 rounded-tl-none rounded-bl-none border border-transparent cursor-pointer">
                            Choose File
                        </label>
                    </div>
                </div>
            </div>
            @error('avatar') <p class="form-text-error">{{ $message }}</p> @enderror
        </div>
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Role Access</h1>
                <span class="text-gray-400">Choose what role user is owned</span>
            </div>
            <div class="pb-3">
                @error('roles') <p class="form-text-error">{{ $message }}</p> @enderror
                <div class="grid grid-cols-1 gap-3 md:grid-cols-2 md:gap-4 lg:grid-cols-4">
                    @foreach($roles as $role)
                        <label class="inline-flex items-center" for="role_{{ $role->id }}">
                            <input type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->id }}" class="form-checkbox"
                                {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                            <span class="ml-2">{{ $role->role }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-primary button-sm">Save User</button>
        </div>
    </form>
@endsection
