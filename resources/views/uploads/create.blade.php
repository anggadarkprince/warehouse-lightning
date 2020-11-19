@extends('layouts.app')

@section('content')
    <form action="{{ route('uploads.store') }}" method="post">
        @csrf
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-3">
                <h1 class="text-xl text-green-500">Create Upload</h1>
                <p class="text-gray-400 leading-tight">Manage upload documents</p>
            </div>
            <div class="py-2">
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="customer_id" class="form-label">{{ __('Customer') }}</label>
                            <div class="w-full">
                                <select class="form-input select-choice" name="customer_id" id="customer_id">
                                    <option value="">No customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}"{{ old('customer_id') == $customer->id ? ' selected' : '' }}>
                                            {{ $customer->customer_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('customer_id') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="booking_type_id" class="form-label">{{ __('Booking Type') }}</label>
                            <div class="w-full">
                                <select class="form-input select-choice" name="booking_type_id" id="booking_type_id" data-search-enable="false">
                                    <option value="">No booking type</option>
                                    @foreach($bookingTypes as $bookingType)
                                        <option value="{{ $bookingType->id }}"{{ old('booking_type_id') == $bookingType->id ? ' selected' : '' }}>
                                            {{ $bookingType->type }} - {{ $bookingType->booking_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('booking_type_id') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="upload_title" class="form-label">{{ __('Upload Title') }}</label>
                    <input id="upload_title" name="upload_title" type="text" class="form-input @error('upload_title') border-red-500 @enderror"
                           placeholder="Upload title" value="{{ old('upload_title') }}">
                    @error('upload_title') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                              placeholder="Upload description" name="description">{{ old('description') }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4" id="form-document">
            <div class="mb-3 flex justify-between items-center">
                <div>
                    <h1 class="text-xl text-green-500">Documents</h1>
                    <p class="text-gray-400 leading-tight">Document list of the upload</p>
                </div>
                <button type="button" class="button-blue button-sm" id="btn-add-document">
                    ADD DOCUMENT
                </button>
            </div>
        </div>

        <div id="document-wrapper">
            <!-- document item added here -->
            <div class="border-dashed border rounded px-6 py-4 mb-4 border-2 document-placeholder{{ old('documents', []) ? ' hidden' : '' }}">
                <p class="text-gray-500">Click add document to add group document</p>
            </div>

            @foreach(old('documents', []) as $uploadDocument)
                @include('upload-documents.partials.template-upload-document', [
                    'id' => data_get($uploadDocument, 'id'),
                    'documentTypeId' => data_get($uploadDocument, 'document_type_id'),
                    'documentName' => data_get($uploadDocument, 'document_name', data_get($uploadDocument, 'document_type.document_name')),
                    'documentDescription' => data_get($uploadDocument, 'description'),
                    'documentNumber' => data_get($uploadDocument, 'document_number'),
                    'documentDate' => \Carbon\Carbon::parse(data_get($uploadDocument, 'document_date'))->format('d F Y'),
                    'documentFiles' => data_get($uploadDocument, 'files', data_get($uploadDocument, 'upload_document_files'))
                ])
            @endforeach
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-primary button-sm">Save Upload</button>
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
