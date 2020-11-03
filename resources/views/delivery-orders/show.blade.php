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
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Destination') }}</p>
                    <p class="text-gray-600">{{ $deliveryOrder->destination }}</p>
                </div>
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

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">{{ __('back') }}</button>
    </div>
@endsection
