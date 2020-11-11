@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2">
            <h1 class="text-xl text-green-500">Upload</h1>
            <span class="text-gray-400">Upload document files</span>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">Upload Number</p>
                    <p class="text-gray-600">{{ $upload->upload_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Customer</p>
                    <p class="text-gray-600">{{ $upload->customer->customer_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Booking Type</p>
                    <p class="text-gray-600">{{ $upload->bookingType->booking_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Upload Title</p>
                    <p class="text-gray-600">{{ $upload->upload_title }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">Status</p>
                    <p class="text-gray-600">{{ $upload->status }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Description</p>
                    <p class="text-gray-600">{{ $upload->description ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Created At</p>
                    <p class="text-gray-600">{{ optional($upload->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Updated At</p>
                    <p class="text-gray-600">{{ optional($upload->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2 flex items-center justify-between">
            <div>
                <h1 class="text-xl text-green-500">Documents</h1>
                <span class="text-gray-400">List of upload documents</span>
            </div>
            <a href="{{ route('uploads.download', ['upload' => $upload->id]) }}" class="button-primary button-sm">
                Download All
            </a>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-4 py-2 w-12">No</th>
                <th class="border-b border-t px-4 py-2 text-left">Document</th>
                <th class="border-b border-t px-4 py-2 text-left">Number</th>
                <th class="border-b border-t px-4 py-2 text-left">Date</th>
                <th class="border-b border-t px-4 py-2 text-left">Description</th>
                <th class="border-b border-t px-4 py-2 text-right">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($upload->uploadDocuments as $index => $document)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-1">{{ $document->documentType->document_name }}</td>
                    <td class="px-4 py-1">{{ $document->document_number ?: '-' }}</td>
                    <td class="px-4 py-1">{{ $document->document_date->format('d F Y') ?: '-' }}</td>
                    <td class="px-4 py-1">{{ $document->description ?: '-' }}</td>
                    <td class="px-4 py-1 text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-blue button-sm">
                                Action <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('uploads.documents.show', ['upload' => $upload->id, 'document' => $document->id]) }}" class="dropdown-item">
                                    <i class="mdi mdi-eye-outline mr-2"></i>View
                                </a>
                                <a href="{{ route('uploads.documents.download', ['upload' => $upload->id, 'document' => $document->id]) }}" class="dropdown-item">
                                    <i class="mdi mdi-file-download-outline mr-2"></i>Download
                                </a>
                                <hr class="border-gray-200 my-1">
                                <button type="button" data-href="{{ route('uploads.documents.destroy', ['upload' => $upload->id, 'document' => $document->id]) }}" data-label="{{ $document->documentType->document_name }}" class="dropdown-item confirm-delete">
                                    <i class="mdi mdi-trash-can-outline mr-2"></i>Delete
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No data available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-3 flex items-center justify-between">
            <div>
                <h1 class="text-xl text-green-500">{{ __('Status Histories') }}</h1>
                <p class="text-gray-400 leading-tight">{{ __('List of upload statuses') }}</p>
            </div>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-2 py-2 w-12">{{ __('No') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Status') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Description') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Data') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Created At') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Created By') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($upload->statusHistories as $index => $statusHistory)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-2 py-1">{{ $statusHistory->status }}</td>
                    <td class="px-2 py-1">{{ $statusHistory->description ?: '-' }}</td>
                    <td class="px-2 py-1">{{ $statusHistory->data ?: '-' }}</td>
                    <td class="px-2 py-1">{{ optional($statusHistory->created_at)->format('d F Y H:i:s') ?: '-' }}</td>
                    <td class="px-2 py-1">{{ optional($statusHistory->creator)->name ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-2 py-2">{{ __('No data available') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
    </div>

    @include('partials.modal-delete')
@endsection
