@extends('layouts.app')

@section('content')
    <form action="{{ route('uploads.update', ['upload' => $upload->id]) }}" method="post">
        @csrf
        @method('put')
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Create Upload</h1>
                <span class="text-gray-400">Manage upload documents</span>
            </div>
            <div class="py-2">
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="customer_id" class="form-label">{{ __('Customer') }}</label>
                            <div class="relative w-full">
                                <select class="form-input pr-8" name="customer_id" id="customer_id">
                                    <option value="">-- Select customer --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}"{{ old('customer_id', $upload->customer_id) == $customer->id ? ' selected' : '' }}>
                                            {{ $customer->customer_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>
                            @error('customer_id') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="booking_type_id" class="form-label">{{ __('Booking Type') }}</label>
                            <div class="relative w-full">
                                <select class="form-input pr-8" name="booking_type_id" id="booking_type_id">
                                    <option value="">-- Select booking type --</option>
                                    @foreach($bookingTypes as $bookingType)
                                        <option value="{{ $bookingType->id }}"{{ old('booking_type_id', $upload->booking_type_id) == $bookingType->id ? ' selected' : '' }}>
                                            {{ $bookingType->type }} - {{ $bookingType->booking_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>
                            @error('booking_type_id') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="upload_title" class="form-label">{{ __('Upload Title') }}</label>
                    <input id="upload_title" name="upload_title" type="text" class="form-input @error('upload_title') border-red-500 @enderror"
                           placeholder="Upload title" value="{{ old('upload_title', $upload->upload_title) }}">
                    @error('upload_title') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                              placeholder="Upload description" name="description">{{ old('description', $upload->description) }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4" id="form-document">
            <div class="mb-2 flex justify-between items-center">
                <div>
                    <h1 class="text-xl text-green-500">Documents</h1>
                    <span class="text-gray-400">Document list of the upload</span>
                </div>
                <button type="button" class="button-blue button-sm" id="btn-add-document">
                    ADD DOCUMENT
                </button>
            </div>
        </div>

        <div id="document-wrapper">
            <!-- document item added here -->
            <div class="border-dashed border rounded px-6 py-4 mb-4 border-2 document-placeholder{{ $upload->uploadDocuments()->count() ? ' hidden' : '' }}">
                <p class="text-gray-500">Click add document to add group document</p>
            </div>

            @foreach($upload->uploadDocuments as $uploadDocument)
                @include('upload-documents.partials.template-upload-document', [
                    'documentTypeId' => $uploadDocument->document_type_id,
                    'documentName' => $uploadDocument->documentType->document_name,
                    'documentDescription' => $uploadDocument->description,
                    'documentNumber' => $uploadDocument->document_number,
                    'documentDate' => $uploadDocument->document_date->format('d F Y'),
                    'documentFiles' => $uploadDocument->uploadDocumentFiles->toArray() // convert to array for form submission fallback
                ])
            @endforeach
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-orange button-sm">Update Upload</button>
        </div>
    </form>

    <script id="document-upload-template" type="x-tmpl-mustache">
        @include('upload-documents.partials.template-upload-document', [
            'documentName' => '@{{ document_name }}',
            'documentDescription' => '@{{ document_description }}',
            'documentNumber' => '@{{ document_number }}',
            'documentDate' => '@{{ document_date }}',
            'documentTypeId' => '@{{ document_type_id }}',
        ])
    </script>
    <script id="file-upload-template" type="x-tmpl-mustache">
        @include('upload-documents.partials.template-upload-file', [
            'fileName' => '@{{ file_name }}',
            'uploadPercentage' => '@{{ upload_percentage }}',
            'src' => '@{{ src }}',
            'documentTypeId' => '@{{ document_type_id }}',
        ])
    </script>

    @include('upload-documents.partials.modal-form-document')
    @include('partials.modal-info')
@endsection

@section('libraries')
    <script src="https://unpkg.com/mustache@latest"></script>
@endsection
