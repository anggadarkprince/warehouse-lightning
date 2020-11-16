@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2">
            <h1 class="text-xl text-green-500">{{ __('Delivery Order') }}</h1>
            <span class="text-gray-400">{{ __('Manage delivery data') }}</span>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Delivery Number') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->delivery_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Type') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->type }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Customer') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->booking->customer->customer_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Reference Number') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->booking->reference_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Booking Number') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->booking->booking_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Delivery Date') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->delivery_date->format('d F Y') }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Driver') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->driver_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Destination') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->destination }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Address') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->destination_address }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Vehicle Name') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->vehicle_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Vehicle Type') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->vehicle_type }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Vehicle Plat') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->vehicle_plat_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Description') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->description ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Created At') }}</p>
                    <p class="text-gray-600">{{ optional($deliveryOrder->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Updated At') }}</p>
                    <p class="text-gray-600">{{ optional($deliveryOrder->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($deliveryOrder->deliveryOrderContainers->count())
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2 flex items-center justify-between">
                <div>
                    <h1 class="text-xl text-green-500">{{ __('Containers') }}</h1>
                    <span class="text-gray-400">{{ __('List of delivery containers') }}</span>
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
                @forelse ($deliveryOrder->deliveryOrderContainers as $index => $deliveryOrderContainer)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-1">
                            <a href="{{ route('containers.show', ['container' => $deliveryOrderContainer->container->id]) }}" class="text-link">
                                {{ $deliveryOrderContainer->container->container_number }}
                            </a>
                        </td>
                        <td class="px-4 py-1">{{ $deliveryOrderContainer->container->container_size }}</td>
                        <td class="px-4 py-1">{{ $deliveryOrderContainer->container->container_type }}</td>
                        <td class="px-4 py-1">{{ $deliveryOrderContainer->is_empty ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-1">{{ $deliveryOrderContainer->seal ?: '-' }}</td>
                        <td class="px-4 py-1">{{ $deliveryOrderContainer->description ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-2">{{ __('No data available') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif

    @if($deliveryOrder->deliveryOrderGoods->count())
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2 flex items-center justify-between">
                <div>
                    <h1 class="text-xl text-green-500">{{ __('Goods') }}</h1>
                    <span class="text-gray-400">{{ __('List of delivery goods') }}</span>
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
                @forelse ($deliveryOrder->deliveryOrderGoods as $index => $deliveryOrderItem)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-1" style="min-width: 200px">
                            <a href="{{ route('goods.show', ['goods' => $deliveryOrderItem->goods->id]) }}" class="text-link block leading-tight">
                                {{ $deliveryOrderItem->goods->item_name }}
                            </a>
                            <span class="text-xs text-gray-500 leading-tight block">{{ $deliveryOrderItem->goods->item_number }}</span>
                        </td>
                        <td class="px-4 py-1">{{ numeric($deliveryOrderItem->unit_quantity) }}</td>
                        <td class="px-4 py-1">{{ $deliveryOrderItem->goods->unit_name }}</td>
                        <td class="px-4 py-1">{{ numeric($deliveryOrderItem->package_quantity) }}</td>
                        <td class="px-4 py-1">{{ $deliveryOrderItem->goods->package_name }}</td>
                        <td class="px-4 py-1">{{ numeric($deliveryOrderItem->weight) }}</td>
                        <td class="px-4 py-1">{{ $deliveryOrderItem->description ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-2">{{ __('No data available') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">{{ __('back') }}</button>
    </div>
@endsection
