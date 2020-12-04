@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2">
            <h1 class="text-xl">{{ __('User') }}</h1>
            <span class="text-gray-400">{{ __('Manage all user account') }}</span>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Name') }}</p>
                    <p class="text-gray-600">{{ $user->name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Email') }}</p>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Verified At') }}</p>
                    <p class="text-gray-600">{{ optional($user->email_verified_at)->format('d F Y H:i:s') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Avatar') }}</p>
                    <p class="text-gray-600">
                        <div class="bg-gray-400 h-20 w-20 inline-block mr-2 rounded-md">
                            <img class="object-cover h-20 w-20 rounded-md" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                        </div>
                    </p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Last Logged In') }}</p>
                    <p class="text-gray-600">{{ optional($user->last_logged_in)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Created At') }}</p>
                    <p class="text-gray-600">{{ optional($user->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Updated At') }}</p>
                    <p class="text-gray-600">{{ optional($user->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2">
            <h1 class="text-xl">{{ __('Role Access') }}</h1>
            <span class="text-gray-400">{{ __('Choose what role user is owned') }}</span>
        </div>
        @if($user->is_admin)
            <span class="bg-red-500 rounded-sm py-1 px-2 text-xs text-white">ADMIN</span>
        @else
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                @forelse($user->roles as $role)
                    <div class="mb-3">
                        <a href="{{ route('roles.show', ['role' => $role->id]) }}" class="text-link">
                            <i class="mdi mdi-check-box-outline mr-1"></i>{{ $role->role }}
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500">{{ __('No role available') }}</p>
                @endforelse
            </div>
        @endif
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">{{ __('Back') }}</button>
        <div>
            @can('update', $user)
                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="button-primary button-sm">
                    {{ __('Edit') }}
                </a>
            @endcan
            @can('delete', $user)
                <button type="button" data-href="{{ route('users.destroy', ['user' => $user->id]) }}" data-label="{{ $user->name }}" class="button-red button-sm confirm-delete">
                    <i class="mdi mdi-trash-can-outline"></i>
                </button>
            @endcan
        </div>
    </div>
    @include('partials.modal-delete')
@endsection
