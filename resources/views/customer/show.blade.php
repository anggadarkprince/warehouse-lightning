@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2">
            <h1 class="text-xl text-green-500">Customer</h1>
            <span class="text-gray-400">Manage all customer</span>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">Customer Name</p>
                    <p class="text-gray-600">{{ $customer->customer_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Customer ID</p>
                    <p class="text-gray-600">{{ $customer->customer_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Address</p>
                    <p class="text-gray-600">{{ $customer->contact_address ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Phone</p>
                    <p class="text-gray-600">{{ $customer->contact_phone ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Email</p>
                    <p class="text-gray-600">{{ $customer->contact_email ?: '-' }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">PIC</p>
                    <p class="text-gray-600">{{ $customer->pic_name ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Description</p>
                    <p class="text-gray-600">{{ $customer->description ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Created At</p>
                    <p class="text-gray-600">{{ optional($customer->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Updated At</p>
                    <p class="text-gray-600">{{ optional($customer->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
    </div>
@endsection
