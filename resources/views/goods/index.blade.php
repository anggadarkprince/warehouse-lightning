@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">{{ __('Goods') }}</h1>
                <p class="text-gray-400 leading-tight">{{ __('Manage all item') }}</p>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
                @can('create', \App\Models\Goods::class)
                    <a href="{{ route('goods.create') }}" class="button-blue button-sm">
                        Create <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4 table-responsive">
            <thead>
            <tr>
                <th class="border-b border-t border-gray-200 p-2 w-12 md:text-center">{{ __('No') }}</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">{{ __('Item Name') }}</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">{{ __('Item Number') }}</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">{{ __('Unit Name') }}</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">{{ __('Unit Package') }}</th>
                <th class="border-b border-t border-gray-200 p-2 md:text-right">{{ __('Action') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($goods as $index => $item)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-2 py-1 md:text-center">{{ $index + 1 }}</td>
                    <td class="px-2 py-1">{{ $item->item_name }}</td>
                    <td class="px-2 py-1">{{ $item->item_number ?: '-' }}</td>
                    <td class="px-2 py-1">{{ $item->unit_name ?: '-' }}</td>
                    <td class="px-2 py-1">{{ $item->package_name ?: '-' }}</td>
                    <td class="px-2 py-1 md:text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                {{ __('Action') }} <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $item)
                                    <a href="{{ route('goods.show', ['goods' => $item->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>{{ __('View') }}
                                    </a>
                                @endcan
                                @can('update', $item)
                                    <a href="{{ route('goods.edit', ['goods' => $item->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-square-edit-outline mr-2"></i>{{ __('Edit') }}
                                    </a>
                                @endcan
                                @can('delete', $item)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('goods.destroy', ['goods' => $item->id]) }}" data-label="{{ $item->item_name }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>{{ __('Delete') }}
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-2" colspan="6">{{ __('No data available') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="px-6">
            {{ $goods->withQueryString()->links() }}
        </div>
    </div>

    @include('goods.partials.modal-filter')
    @include('partials.modal-delete')
@endsection
