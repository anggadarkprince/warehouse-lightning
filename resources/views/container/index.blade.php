@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow px-6 py-4">
        <div class="flex justify-between items-center mb-3">
            <div>
                <h1 class="text-xl text-green-500">Container</h1>
                <span class="text-gray-400">Manage all container</span>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
                @can('create', \App\Models\Container::class)
                    <a href="{{ route('containers.create') }}" class="button-blue button-sm">
                        Create <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-4 py-2 w-12">No</th>
                <th class="border-b border-t px-4 py-2 text-left">Container Number</th>
                <th class="border-b border-t px-4 py-2 text-left">Shipping Line</th>
                <th class="border-b border-t px-4 py-2 text-left">Type</th>
                <th class="border-b border-t px-4 py-2 text-left">Size</th>
                <th class="border-b border-t px-4 py-2 text-right">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($containers as $index => $container)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-1">{{ $container->container_number }}</td>
                    <td class="px-4 py-1">{{ $container->shipping_line ?: '-' }}</td>
                    <td class="px-4 py-1">{{ $container->container_size ?: '-' }}</td>
                    <td class="px-4 py-1">{{ $container->container_type ?: '-' }}</td>
                    <td class="px-4 py-1 text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                Action <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $container)
                                    <a href="{{ route('containers.show', ['container' => $container->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>View
                                    </a>
                                @endcan
                                @can('update', $container)
                                <a href="{{ route('containers.edit', ['container' => $container->id]) }}" class="dropdown-item">
                                    <i class="mdi mdi-square-edit-outline mr-2"></i>Edit
                                </a>
                                @endcan
                                @can('delete', $container)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('containers.destroy', ['container' => $container->id]) }}" data-label="{{ $container->container_number }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>Delete
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No data available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $containers->withQueryString()->links() }}
    </div>

    @include('container.partials.modal-filter')
    @include('partials.modal-delete')
@endsection
