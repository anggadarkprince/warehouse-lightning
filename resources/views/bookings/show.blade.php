@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2">
            <h1 class="text-xl text-green-500">{{ __('Booking') }}</h1>
            <span class="text-gray-400">{{ __('Manage booking data') }}</span>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Booking Number') }}</p>
                    <p class="text-gray-600">{{ $booking->booking_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Customer') }}</p>
                    <p class="text-gray-600">{{ $booking->customer->customer_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Type') }}</p>
                    <p class="text-gray-600">{{ $booking->bookingType->type }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Booking Type') }}</p>
                    <p class="text-gray-600">
                        {{ $booking->bookingType->booking_name }}
                    </p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Reference Number') }}</p>
                    <p class="text-gray-600">{{ $booking->reference_number }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Reference Upload') }}</p>
                    <p class="text-gray-600">{{ $booking->upload->upload_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Status') }}</p>
                    <p class="text-gray-600">{{ $booking->status }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Description') }}</p>
                    <p class="text-gray-600">{{ $booking->description ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Created At') }}</p>
                    <p class="text-gray-600">{{ optional($booking->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Updated At') }}</p>
                    <p class="text-gray-600">{{ optional($booking->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2">
            <h1 class="text-xl text-green-500">{{ __('Booking Detail') }}</h1>
            <span class="text-gray-400">{{ __('Information about the booking') }}</span>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Supplier Name') }}</p>
                    <p class="text-gray-600">{{ $booking->supplier_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Owner Name') }}</p>
                    <p class="text-gray-600">{{ $booking->owner_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Shipper Name') }}</p>
                    <p class="text-gray-600">{{ $booking->shipper_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Voy Flight') }}</p>
                    <p class="text-gray-600">{{ $booking->voy_flight }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Arrival Date') }}</p>
                    <p class="text-gray-600">{{ $booking->arrival_date->format('d F Y') }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('TPS') }}</p>
                    <p class="text-gray-600">{{ $booking->tps }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Total CIF') }}</p>
                    <p class="text-gray-600">{{ $booking->total_cif }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Total Gross Weight') }}</p>
                    <p class="text-gray-600">{{ $booking->total_gross_weight }} KG</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Total Net Weight') }}</p>
                    <p class="text-gray-600">{{ $booking->total_weight }} KG</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('XML File') }}</p>
                    <p class="text-gray-600">
                        @if(empty($booking->xml_file))
                            -
                        @else
                            <a href="{{ route('bookings.xml', ['booking' => $booking->id]) }}" class="text-link">
                                {{ __('Download') }}
                            </a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2 flex items-center justify-between">
            <div>
                <h1 class="text-xl text-green-500">{{ __('Containers') }}</h1>
                <span class="text-gray-400">{{ __('List of booking containers') }}</span>
            </div>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-4 py-2 w-12">{{ __('No') }}</th>
                <th class="border-b border-t px-4 py-2 text-left">{{ __('Container Number') }}</th>
                <th class="border-b border-t px-4 py-2 text-left">{{ __('Size') }}</th>
                <th class="border-b border-t px-4 py-2 text-left">{{ __('Type') }}</th>
                <th class="border-b border-t px-4 py-2 text-left">{{ __('Is Empty') }}</th>
                <th class="border-b border-t px-4 py-2 text-left">{{ __('Seal') }}</th>
                <th class="border-b border-t px-4 py-2 text-left">{{ __('Description') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($booking->bookingContainers as $index => $bookingContainer)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-1">
                        <a href="{{ route('containers.show', ['container' => $bookingContainer->container->id]) }}" class="text-link">
                            {{ $bookingContainer->container->container_number }}
                        </a>
                    </td>
                    <td class="px-4 py-1">{{ $bookingContainer->container->container_size }}</td>
                    <td class="px-4 py-1">{{ $bookingContainer->container->container_type }}</td>
                    <td class="px-4 py-1">{{ $bookingContainer->is_empty ? 'Yes' : 'No' }}</td>
                    <td class="px-4 py-1">{{ $bookingContainer->seal ?: '-' }}</td>
                    <td class="px-4 py-1">{{ $bookingContainer->description ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">{{ __('No data available') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>


    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2 flex items-center justify-between">
            <div>
                <h1 class="text-xl text-green-500">{{ __('Goods') }}</h1>
                <span class="text-gray-400">{{ __('List of booking goods') }}</span>
            </div>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-4 py-2 w-12">{{ __('No') }}</th>
                <th class="border-b border-t px-4 py-2 text-left">{{ __('Item Name') }}</th>
                <th class="border-b border-t px-4 py-2 text-left">{{ __('Unit Qty') }}</th>
                <th class="border-b border-t px-4 py-2 text-left">{{ __('Unit Name') }}</th>
                <th class="border-b border-t px-4 py-2 text-left">{{ __('Package Qty') }}</th>
                <th class="border-b border-t px-4 py-2 text-left">{{ __('Package Name') }}</th>
                <th class="border-b border-t px-4 py-2 text-left">{{ __('Weight') }}</th>
                <th class="border-b border-t px-4 py-2 text-left">{{ __('Description') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($booking->bookingGoods as $index => $bookingItem)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-1" style="min-width: 200px">
                        <a href="{{ route('goods.show', ['goods' => $bookingItem->goods->id]) }}" class="text-link block leading-tight">
                            {{ $bookingItem->goods->item_name }}
                        </a>
                        <span class="text-xs text-gray-500 leading-tight block">{{ $bookingItem->goods->item_number }}</span>
                    </td>
                    <td class="px-4 py-1">{{ numeric($bookingItem->unit_quantity) }}</td>
                    <td class="px-4 py-1">{{ $bookingItem->goods->unit_name }}</td>
                    <td class="px-4 py-1">{{ numeric($bookingItem->package_quantity) }}</td>
                    <td class="px-4 py-1">{{ $bookingItem->goods->package_name }}</td>
                    <td class="px-4 py-1">{{ numeric($bookingItem->weight) }}</td>
                    <td class="px-4 py-1">{{ $bookingItem->description ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">{{ __('No data available') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">{{ __('back') }}</button>
    </div>
@endsection
