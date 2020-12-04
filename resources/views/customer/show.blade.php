@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-3">
            <h1 class="text-xl text-green-500">{{ __('Customer') }}</h1>
            <p class="text-gray-400 leading-tight">{{ __('Manage all customer') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Customer Name') }}</p>
                    <p class="text-gray-600">{{ $customer->customer_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Customer ID') }}</p>
                    <p class="text-gray-600">{{ $customer->customer_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Address') }}</p>
                    <p class="text-gray-600">{{ $customer->contact_address ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Phone') }}</p>
                    <p class="text-gray-600">{{ $customer->contact_phone ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Email') }}</p>
                    <p class="text-gray-600">{{ $customer->contact_email ?: '-' }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('PIC') }}</p>
                    <p class="text-gray-600">{{ $customer->pic_name ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Description') }}</p>
                    <p class="text-gray-600">{{ $customer->description ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Created At') }}</p>
                    <p class="text-gray-600">{{ optional($customer->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Updated At') }}</p>
                    <p class="text-gray-600">{{ optional($customer->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">{{ __('Back') }}</button>
    </div>
@endsection
