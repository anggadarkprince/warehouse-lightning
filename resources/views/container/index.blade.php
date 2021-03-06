@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow py-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">{{ __('Container') }}</h1>
                <p class="text-gray-400 leading-tight">{{ __('Manage all container') }}</p>
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
                        {{ __('Create') }} <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4 table-responsive">
            <thead>
            <tr>
                <th class="border-b border-t border-gray-200 p-2 w-12 md:text-center">{{ __('No') }}</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">{{ __('Container Number') }}</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">{{ __('Shipping Line') }}</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">{{ __('Type') }}</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">{{ __('Size') }}</th>
                <th class="border-b border-t border-gray-200 p-2 md:text-right">{{ __('Action') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($containers as $index => $container)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-2 py-1 md:text-center">{{ $index + 1 }}</td>
                    <td class="px-2 py-1">{{ $container->container_number }}</td>
                    <td class="px-2 py-1">{{ $container->shipping_line ?: '-' }}</td>
                    <td class="px-2 py-1">{{ $container->container_size ?: '-' }}</td>
                    <td class="px-2 py-1">{{ $container->container_type ?: '-' }}</td>
                    <td class="px-2 py-1 md:text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                {{ __('Action') }} <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $container)
                                    <a href="{{ route('containers.show', ['container' => $container->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>{{ __('View') }}
                                    </a>
                                @endcan
                                @can('update', $container)
                                <a href="{{ route('containers.edit', ['container' => $container->id]) }}" class="dropdown-item">
                                    <i class="mdi mdi-square-edit-outline mr-2"></i>{{ __('Edit') }}
                                </a>
                                @endcan
                                @can('delete', $container)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('containers.destroy', ['container' => $container->id]) }}" data-label="{{ $container->container_number }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>{{ __('Delete') }}
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-2" colspan="5">{{ __('No data available') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="px-6">
            {{ $containers->withQueryString()->links() }}
        </div>
    </div>

    @include('container.partials.modal-filter')
    @include('partials.modal-delete')
@endsection
