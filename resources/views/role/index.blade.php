@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm py-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">User Role</h1>
                <p class="text-gray-400 leading-tight">Account role permission</p>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
                @can('create', \App\Models\Role::class)
                    <a href="{{ route('roles.create') }}" class="button-blue button-sm">
                        Create <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t border-gray-200 p-2 w-12">No</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Role</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Permission Total</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Description</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Created At</th>
                <th class="border-b border-t border-gray-200 p-2 text-right">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($roles as $index => $role)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-2 py-1">{{ $role->role }}</td>
                    <td class="px-2 py-1">{{ $role->permission_total }}</td>
                    <td class="px-2 py-1">{{ $role->description ?: '-' }}</td>
                    <td class="px-2 py-1">{{ optional($role->created_at)->format('d F Y H:i') }}</td>
                    <td class="px-2 py-1 text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                Action <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $role)
                                    <a href="{{ route('roles.show', ['role' => $role->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>View
                                    </a>
                                @endcan
                                @can('update', $role)
                                <a href="{{ route('roles.edit', ['role' => $role->id]) }}" class="dropdown-item">
                                    <i class="mdi mdi-square-edit-outline mr-2"></i>Edit
                                </a>
                                @endcan
                                @can('delete', $role)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('roles.destroy', ['role' => $role->id]) }}" data-label="{{ $role->role }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>Delete
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-2" colspan="5">No data available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="px-6">
            {{ $roles->withQueryString()->links() }}
        </div>
    </div>

    @include('role.partials.modal-filter')
    @include('partials.modal-delete')
@endsection
