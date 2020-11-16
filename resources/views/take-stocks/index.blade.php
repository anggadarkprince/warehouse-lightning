@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow py-4 mb-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">Take Stocks</h1>
                <span class="text-gray-400">Manage opname data</span>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
                @can('create', \App\Models\TakeStock::class)
                    <a href="{{ route('take-stocks.create') }}" class="button-blue button-sm">
                        Create <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-4 py-2 w-12">No</th>
                <th class="border-b border-t px-4 py-2 text-left">Take Stock Number</th>
                <th class="border-b border-t px-4 py-2 text-left">Date</th>
                <th class="border-b border-t px-4 py-2 text-left">Description</th>
                <th class="border-b border-t px-4 py-2 text-left">Status</th>
                <th class="border-b border-t px-4 py-2 text-right">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($takeStocks as $index => $takeStock)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-1">{{ $takeStock->take_stock_number }}</td>
                    <td class="px-4 py-1">{{ $takeStock->created_at->format('d F Y') }}</td>
                    <td class="px-4 py-1">{{ $takeStock->description ?: '-' }}</td>
                    <td class="px-4 py-1">{{ $takeStock->status ?: '-' }}</td>
                    <td class="px-4 py-1 text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                Action <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $takeStock)
                                    <a href="{{ route('delivery-orders.show', ['delivery_order' => $takeStock->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>View
                                    </a>
                                    <a href="{{ route('delivery-orders.print', ['delivery_order' => $takeStock->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-printer mr-2"></i>Print
                                    </a>
                                @endcan
                                @can('update', $takeStock)
                                    <a href="{{ route('delivery-orders.edit', ['delivery_order' => $takeStock->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-square-edit-outline mr-2"></i>Edit
                                    </a>
                                @endcan
                                @can('delete', $takeStock)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('delivery-orders.destroy', ['delivery_order' => $takeStock->id]) }}" data-label="{{ $takeStock->delivery_number }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>Delete
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-4 py-2" colspan="6">No data available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="px-6">
            {{ $takeStocks->withQueryString()->links() }}
        </div>
    </div>

    @include('partials.modal-delete')
    @include('partials.modal-confirm')
@endsection
