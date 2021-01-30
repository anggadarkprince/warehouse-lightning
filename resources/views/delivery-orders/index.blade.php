@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">Delivery Orders</h1>
                <p class="text-gray-400 leading-tight">Manage delivery data</p>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
                @can('create', \App\Models\DeliveryOrder::class)
                    <a href="{{ route('delivery-orders.create') }}" class="button-blue button-sm">
                        Create <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4 table-responsive">
            <thead>
            <tr>
                <th class="border-b border-t border-gray-200 p-2 w-12 md:text-center">No</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Delivery Number</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Type</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Booking</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Customer</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Delivery Date</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Driver</th>
                <th class="border-b border-t border-gray-200 p-2 md:text-right">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($deliveryOrders as $index => $deliveryOrder)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-2 py-1 md:text-center">{{ $index + 1 }}</td>
                    <td class="px-2 py-1">{{ $deliveryOrder->delivery_number }}</td>
                    <td class="px-2 py-1">{{ $deliveryOrder->type }}</td>
                    <td class="px-2 py-1">
                        <p class="leading-none mt-1">
                            <a class="text-link" href="{{ route('bookings.show', ['booking' => $deliveryOrder->booking_id]) }}">
                                {{ $deliveryOrder->booking->booking_number }}
                            </a>
                        </p>
                        <p class="text-gray-500 text-xs leading-tight">{{ $deliveryOrder->booking->reference_number }}</p>
                    </td>
                    <td class="px-2 py-1">{{ $deliveryOrder->booking->customer->customer_name ?: '-' }}</td>
                    <td class="px-2 py-1">{{ $deliveryOrder->delivery_date->format('d F Y') }}</td>
                    <td class="px-2 py-1">{{ $deliveryOrder->driver_name ?: '-' }}</td>
                    <td class="px-2 py-1 md:text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                Action <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $deliveryOrder)
                                    <a href="{{ route('delivery-orders.show', ['delivery_order' => $deliveryOrder->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>View
                                    </a>
                                    <a href="{{ route('delivery-orders.print', ['delivery_order' => $deliveryOrder->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-printer mr-2"></i>Print
                                    </a>
                                @endcan
                                @can('update', $deliveryOrder)
                                    <a href="{{ route('delivery-orders.edit', ['delivery_order' => $deliveryOrder->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-square-edit-outline mr-2"></i>Edit
                                    </a>
                                @endcan
                                @can('delete', $deliveryOrder)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('delivery-orders.destroy', ['delivery_order' => $deliveryOrder->id]) }}" data-label="{{ $deliveryOrder->delivery_number }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>Delete
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-2" colspan="8">No data available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="px-6">
            {{ $deliveryOrders->withQueryString()->links() }}
        </div>
    </div>

    @include('delivery-orders.partials.modal-filter')
    @include('partials.modal-delete')
    @include('partials.modal-confirm')
@endsection
