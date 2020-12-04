@extends('layouts.app')

@section('content')
    <form action="{{ route('document-types.update', ['document_type' => $documentType->id]) }}" method="post">
        @csrf
        @method('put')
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-3">
                <h1 class="text-xl text-green-500">{{ __('Edit Document Type') }}</h1>
                <p class="text-gray-400 leading-tight">{{ __('Manage all document type') }}</p>
            </div>
            @include('document-type.partials.form')
        </div>
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">{{ __('Back') }}</button>
            <button type="submit" class="button-orange button-sm">{{ __('Update Document Type') }}</button>
        </div>
    </form>
@endsection
