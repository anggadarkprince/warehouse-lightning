@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-3">
            <h1 class="text-xl text-green-500">{{ __('Document Type') }}</h1>
            <p class="text-gray-400 leading-tight">{{ __('Manage all document type') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Document Name') }}</p>
                    <p class="text-gray-600">{{ $documentType->document_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Description') }}</p>
                    <p class="text-gray-600">{{ $documentType->description }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Created At') }}</p>
                    <p class="text-gray-600">{{ optional($documentType->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">{{ __('Updated At') }}</p>
                    <p class="text-gray-600">{{ optional($documentType->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">{{ __('Back') }}</button>
    </div>
@endsection
