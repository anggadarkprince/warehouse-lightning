@extends('layouts.app')

@section('content')
    @if($customers->isNotEmpty())
        <div class="bg-white rounded shadow-sm py-4 mb-4">
            <div class="flex justify-between items-center mb-3 px-6">
                <div>
                    <h1 class="text-xl text-green-500">Customer result of "{{ $q }}"</h1>
                    <p class="text-gray-400 leading-tight">Customer search of data</p>
                </div>
            </div>
            <table class="table-auto w-full mb-4">
                <thead>
                <tr>
                    <th class="border-b border-t border-gray-200 p-2 w-12">No</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Customer Name</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">PIC</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Address</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Phone</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $index => $customer)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-2 py-1 leading-tight">
                            {{ $customer->customer_name }}<br>
                            <small class="text-gray-500 text-xs">{{ $customer->customer_number }}</small>
                        </td>
                        <td class="px-2 py-1">{{ $customer->pic_name ?: '-' }}</td>
                        <td class="px-2 py-1">{{ $customer->contact_address ?: '-' }}</td>
                        <td class="px-2 py-1">{{ $customer->contact_phone ?: '-' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if($bookings->isNotEmpty())
        <div class="bg-white rounded shadow-sm py-4 mb-4">
            <div class="flex justify-between items-center mb-3 px-6">
                <div>
                    <h1 class="text-xl text-green-500">Booking result of "{{ $q }}"</h1>
                    <p class="text-gray-400 leading-tight">Booking search of data</p>
                </div>
            </div>
            <table class="table-auto w-full mb-4">
                <thead>
                <tr>
                    <th class="border-b border-t border-gray-200 p-2 w-12">No</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Reference Number</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Type</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Customer Name</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Booking Type</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $bookingStatuses = [
                        'DRAFT' => 'bg-gray-200',
                        'VALIDATED' => 'bg-green-500',
                    ];
                ?>
                @foreach($bookings as $index => $booking)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-2 py-1">
                            <p class="leading-none mt-1">{{ $booking->booking_number }}</p>
                            <p class="text-gray-500 text-xs leading-tight">{{ $booking->reference_number }}</p>
                        </td>
                        <td class="px-2 py-1">
                            <p class="leading-none mt-1">{{ $booking->bookingType->type ?: '-' }}</p>
                            <p class="text-gray-500 text-xs leading-tight">{{ optional($booking->upload)->upload_number ?: 'No upload' }}</p>
                        </td>
                        <td class="px-2 py-1">{{ $booking->customer->customer_name ?: '-' }}</td>
                        <td class="px-2 py-1">{{ $booking->bookingType->booking_name ?: '-' }}</td>
                        <td class="px-2 py-1">
                            <span class="px-2 py-1 rounded text-xs {{ $booking->status == 'DRAFT' ? '' : 'text-white' }} {{ data_get($bookingStatuses, $booking->status, 'bg-gray-200') }}">
                                {{ $booking->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if($workOrders->isNotEmpty())
        <div class="bg-white rounded shadow-sm py-4 mb-4">
            <div class="flex justify-between items-center mb-3 px-6">
                <div>
                    <h1 class="text-xl text-green-500">Job result of "{{ $q }}"</h1>
                    <p class="text-gray-400 leading-tight">Work order search of data</p>
                </div>
            </div>
            <table class="table-auto w-full mb-4">
                <thead>
                <tr>
                    <th class="border-b border-t border-gray-200 p-2 w-12">No</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Job Number</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Booking</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Customer</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Assigned To</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Completed At</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $workOrderStatuses = [
                    'QUEUED' => 'bg-gray-200',
                    'TAKEN' => 'bg-orange-500',
                    'COMPLETED' => 'bg-blue-500',
                    'VALIDATED' => 'bg-green-500',
                    'REJECTED' => 'bg-red-500',
                ];
                ?>
                @foreach($workOrders as $index => $workOrder)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-2 py-1">
                            <p>{{ $workOrder->job_number }}</p>
                            <p class="text-gray-500 text-xs leading-tight">{{ $workOrder->job_type }}</p>
                        </td>
                        <td class="px-2 py-1">
                            <p>
                                <a class="text-link" href="{{ route('bookings.show', ['booking' => $workOrder->booking_id]) }}">
                                    {{ $workOrder->booking->booking_number }}
                                </a>
                            </p>
                            <p class="text-gray-500 text-xs leading-tight">{{ $workOrder->booking->reference_number }}</p>
                        </td>
                        <td class="px-2 py-1">{{ $workOrder->booking->customer->customer_name ?: '-' }}</td>
                        <td class="px-2 py-1">{{ optional($workOrder->user)->name ?: '-' }}</td>
                        <td class="px-2 py-1">{{ optional($workOrder->completed_at)->format('d M Y  H:i') ?: '-' }}</td>
                        <td class="px-2 py-1">
                            <span class="px-2 py-1 rounded text-xs {{ $workOrder->status == 'QUEUED' ? '' : 'text-white' }} {{ data_get($workOrderStatuses, $workOrder->status, 'bg-gray-200') }}">
                                {{ $workOrder->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if($deliveryOrders->isNotEmpty())
        <div class="bg-white rounded shadow-sm py-4 mb-4">
            <div class="flex justify-between items-center mb-3 px-6">
                <div>
                    <h1 class="text-xl text-green-500">Delivery result of "{{ $q }}"</h1>
                    <p class="text-gray-400 leading-tight">Delivery order search of data</p>
                </div>
            </div>
            <table class="table-auto w-full mb-4">
                <thead>
                <tr>
                    <th class="border-b border-t border-gray-200 p-2 w-12">No</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Delivery Number</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Type</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Booking</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Customer</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Delivery Date</th>
                    <th class="border-b border-t border-gray-200 p-2 text-left">Driver</th>
                </tr>
                </thead>
                <tbody>
                @foreach($deliveryOrders as $index => $deliveryOrder)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
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
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if($customers->isEmpty() && $bookings->isEmpty() && $workOrders->isEmpty() && $deliveryOrders->isEmpty())
        <div class="border-2 rounded border-dashed px-3 py-2 mb-4 text-gray-600">
            No any data found, try another query
        </div>
    @endif

@endsection
