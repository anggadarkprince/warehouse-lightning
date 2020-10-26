@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2">
            <h1 class="text-xl text-green-500">Upload Documents</h1>
            <span class="text-gray-400">Upload document files</span>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">Document Name</p>
                    <p class="text-gray-600">{{ $document->documentType->document_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Document Date</p>
                    <p class="text-gray-600">{{ $document->document_date }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Upload Number</p>
                    <p class="text-gray-600">{{ $document->document_number }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">Description</p>
                    <p class="text-gray-600">{{ $document->description ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Created At</p>
                    <p class="text-gray-600">{{ optional($document->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Updated At</p>
                    <p class="text-gray-600">{{ optional($document->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2 flex items-center justify-between">
            <div>
                <h1 class="text-xl text-green-500">Document Files</h1>
                <span class="text-gray-400">List of document files</span>
            </div>
            <a href="{{ route('uploads.documents.download', ['upload' => $upload->id, 'document' => $document->id]) }}" class="button-primary button-sm">
                Download All
            </a>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-4 py-2 w-12">No</th>
                <th class="border-b border-t px-4 py-2 text-left">File</th>
                <th class="border-b border-t px-4 py-2 text-left">Preview</th>
                <th class="border-b border-t px-4 py-2 text-left">Created At</th>
                <th class="border-b border-t px-4 py-2 text-right">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($document->uploadDocumentFiles as $index => $file)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-1">{{ $file->file_name ?: basename($file->src) }}</td>
                    <td class="px-4 py-1">
                        <a href="{{ route('uploads.documents.files.preview', ['upload' => $upload->id, 'document' => $document->id, 'file' => $file->id]) }}" class="text-link">
                            Open
                        </a>
                    </td>
                    <td class="px-4 py-1">{{ $file->created_at->format('d F Y H:i:s') }}</td>
                    <td class="px-4 py-1 text-right">
                        <a href="{{ route('uploads.documents.files.download', ['upload' => $upload->id, 'document' => $document->id, 'file' => $file->id]) }}" class="button-blue button-sm">
                            Download
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No data available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
    </div>
@endsection
