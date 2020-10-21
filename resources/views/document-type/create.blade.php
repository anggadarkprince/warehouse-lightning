@extends('layouts.app')

@section('content')
    <form action="{{ route('document-types.store') }}" method="post">
        @csrf
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Create Document Type</h1>
                <span class="text-gray-400">Manage all document type</span>
            </div>
            <div class="py-2 space-y-4">
                <div class="flex flex-wrap">
                    <label for="document_name" class="form-label">{{ __('Document Name') }}</label>
                    <input id="document_name" name="document_name" type="text" class="form-input @error('document_name') border-red-500 @enderror"
                           placeholder="Document type name" value="{{ old('document_name') }}">
                    @error('document_name') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="flex flex-wrap">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                              placeholder="Document type description" name="description">{{ old('description') }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-primary button-sm">Save Document Type</button>
        </div>
    </form>
@endsection
