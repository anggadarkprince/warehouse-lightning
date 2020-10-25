@extends('layouts.app')

@section('content')
    <form action="{{ route('uploads.store') }}" method="post">
        @csrf
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
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}"{{ old('customer_id') == $customer->id ? ' selected' : '' }}>
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
                                    @foreach($bookingTypes as $bookingType)
                                        <option value="{{ $bookingType->id }}"{{ old('booking_type_id') == $bookingType->id ? ' selected' : '' }}>
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
            <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 document-item">
                <div class="flex items-start justify-between sm:items-center sm:justify-start border-b pb-2">
                    <div class="flex flex-col flex-grow sm:flex-row sm:items-center">
                        <div class="lg:w-64 sm:w-1/3 sm:mr-3">
                            <h3 class="text-xl text-blue-500 document-name">Invoice</h3>
                            <p class="text-gray-400 text-sm document-description">No description</p>
                        </div>
                        <div class="flex flex-row sm:w-1/2">
                            <div class="text-gray-600 text-sm sm:text-base sm:w-1/2 mr-2 leading-tight">
                                <p class="text-xs text-gray-400 hidden sm:block">DOCUMENT NUMBER</p>
                                <p class="document-number">SD342342</p>
                            </div>
                            <div class="text-gray-500 text-sm sm:text-gray-600 sm:text-base sm:w-1/2 leading-tight">
                                <p class="text-xs text-gray-400 hidden sm:block">DOCUMENT DATE</p>
                                <p class="document-date">28 OCT 2020</p>
                            </div>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <div class="relative inline-block">
                            <input class="input-file absolute hidden top-0" type="file" name="input_file_1" id="input_file_1">
                            <label for="input_file_1" class="button-primary button-sm cursor-pointer">
                                <i class="mdi mdi-plus"></i><span class="hidden sm:inline-block">ADD FILE</span>
                            </label>
                        </div>
                        <button type="button" class="button-blue button-sm" id="btn-add-document">
                            <i class="mdi mdi-square-edit-outline"></i>
                        </button>
                        <button type="button" class="button-red button-sm" id="btn-add-document">
                            <i class="mdi mdi-trash-can-outline"></i>
                        </button>
                    </div>
                </div>
                <ul class="list-inside pt-2 space-y-1">
                    <li class="flex items-center">
                        <p class="file-name w-1/2 text-sm mr-3 truncate lg:w-64 sm:w-1/3 sm:text-base">
                            1. Roles-20201022045201.xlsx
                        </p>
                        <div class="flex flex-no-wrap items-center">
                            <div class="w-16 sm:w-32 h-3 bg-gray-200 rounded-sm mr-2">
                                <div class="h-3 bg-green-500 rounded-sm upload-progress" style="width: 50%;"></div>
                            </div>
                            <span class="upload-percentage">50%</span>
                        </div>
                        <button type="button" class="ml-auto button-orange px-2 py-1 text-sm btn-delete-file">
                            <i class="mdi mdi-trash-can-outline"></i>
                        </button>
                    </li>
                    <li class="flex items-center">
                        <p class="file-name w-1/2 text-sm mr-3 truncate lg:w-64 sm:w-1/3 sm:text-base">
                            2. Goods-20201023013834.xlsx
                        </p>
                        <div class="flex flex-no-wrap items-center">
                            <div class="w-16 sm:w-32 h-3 bg-gray-200 rounded-sm mr-2">
                                <div class="h-3 bg-green-500 rounded-sm upload-progress" style="width: 50%;"></div>
                            </div>
                            <span class="upload-percentage">50%</span>
                        </div>
                        <button type="button" class="ml-auto button-orange px-2 py-1 text-sm btn-delete-file">
                            <i class="mdi mdi-trash-can-outline"></i>
                        </button>
                    </li>
                </ul>
            </div>
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

@section('libraries')
    <script src="https://unpkg.com/mustache@latest"></script>
@endsection
