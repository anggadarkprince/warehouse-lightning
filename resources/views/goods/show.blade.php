@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2">
            <h1 class="text-xl text-green-500">Goods</h1>
            <span class="text-gray-400">Manage all item</span>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">Item Name</p>
                    <p class="text-gray-600">{{ $goods->item_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Item Number</p>
                    <p class="text-gray-600">{{ $goods->item_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Unit Name</p>
                    <p class="text-gray-600">{{ $goods->unit_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Package Name</p>
                    <p class="text-gray-600">{{ $goods->package_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Description</p>
                    <p class="text-gray-600">{{ $goods->description }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">Weight</p>
                    <p class="text-gray-600">{{ numeric($goods->weight) }} KG</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Gross Weight</p>
                    <p class="text-gray-600">{{ numeric($goods->gross_weight) }} KG</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Created At</p>
                    <p class="text-gray-600">{{ optional($goods->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Updated At</p>
                    <p class="text-gray-600">{{ optional($goods->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
    </div>
@endsection
