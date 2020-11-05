@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow py-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">User Account</h1>
                <span class="text-gray-400">Manage all user account</span>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
                @can('create', \App\Models\User::class)
                    <a href="{{ route('users.create') }}" class="button-blue button-sm">
                        Create <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-4 py-2 w-12">No</th>
                <th class="border-b border-t px-4 py-2 text-left">Name</th>
                <th class="border-b border-t px-4 py-2 text-left">Email</th>
                <th class="border-b border-t px-4 py-2 text-left">Type</th>
                <th class="border-b border-t px-4 py-2 text-left">Group</th>
                <th class="border-b border-t px-4 py-2 text-left">Registered At</th>
                <th class="border-b border-t px-4 py-2 text-right">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $index => $user)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-1">
                        <div class="flex items-center my-1">
                            <div class="bg-gray-400 h-10 w-10 inline-block mr-2 rounded-md">
                                <img class="object-cover h-10 w-10 rounded-md" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                            </div>
                            {{ $user->name }}
                        </div>
                    </td>
                    <td class="px-4 py-1">{{ $user->email }}</td>
                    <td class="px-4 py-1">{{ $user->type ?: '-' }}</td>
                    <td class="px-4 py-1">
                        @if($user->is_admin)
                            <span class="bg-red-500 rounded-sm py-1 px-2 text-xs text-white">ADMIN</span>
                        @else
                            {!! optional(optional($user->roles)->pluck('role'))->implode('<br>') ?: '-' !!}
                        @endif
                    </td>
                    <td class="px-4 py-1">{{ optional($user->created_at)->format('d M Y H:i') }}</td>
                    <td class="px-4 py-1 text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                Action <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $user)
                                    <a href="{{ route('users.show', ['user' => $user->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>View
                                    </a>
                                @endcan
                                @can('update', $user)
                                    <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-square-edit-outline mr-2"></i>Edit
                                    </a>
                                @endcan
                                @can('delete', $user)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('users.destroy', ['user' => $user->id]) }}" data-label="{{ $user->name }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>Delete
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-4 py-2" colspan="7">No data available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="px-6">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>

    @include('user.partials.modal-filter')
    @include('partials.modal-delete')
@endsection
