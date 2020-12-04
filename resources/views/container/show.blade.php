@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2">
            <h1 class="text-xl text-green-500">{{ __('Container') }}</h1>
            <p class="text-gray-400 leading-tight">{{ __('Manage all container') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Container Number') }}</p>
                    <p class="text-gray-600">{{ $container->container_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Container Size') }}</p>
                    <p class="text-gray-600">{{ $container->container_size }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Container Type') }}</p>
                    <p class="text-gray-600">{{ $container->container_type }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Description') }}</p>
                    <p class="text-gray-600">{{ $container->description }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Shipping Line') }}</p>
                    <p class="text-gray-600">{{ $container->shipping_line }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Created At') }}</p>
                    <p class="text-gray-600">{{ optional($container->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Updated At') }}</p>
                    <p class="text-gray-600">{{ optional($container->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">{{ __('Back') }}</button>
    </div>
@endsection
