@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-3">
            <h1 class="text-xl text-green-500">{{ __('Goods') }}</h1>
            <p class="text-gray-400 leading-tight">{{ __('Manage all item') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Item Name') }}</p>
                    <p class="text-gray-600">{{ $goods->item_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Item Number') }}</p>
                    <p class="text-gray-600">{{ $goods->item_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Unit Name') }}</p>
                    <p class="text-gray-600">{{ $goods->unit_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Package Name') }}</p>
                    <p class="text-gray-600">{{ $goods->package_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Description') }}</p>
                    <p class="text-gray-600">{{ $goods->description }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Weight') }}</p>
                    <p class="text-gray-600">{{ numeric($goods->unit_weight) }} KG</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Gross Weight') }}</p>
                    <p class="text-gray-600">{{ numeric($goods->unit_gross_weight) }} KG</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Created At') }}</p>
                    <p class="text-gray-600">{{ optional($goods->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Updated At') }}</p>
                    <p class="text-gray-600">{{ optional($goods->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">{{ __('Back') }}</button>
    </div>
@endsection
