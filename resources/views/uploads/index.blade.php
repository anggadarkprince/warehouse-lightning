@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow py-4 mb-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">Uploads</h1>
                <span class="text-gray-400">Manage upload documents</span>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
                @can('create', \App\Models\Upload::class)
                    <a href="{{ route('uploads.create') }}" class="button-blue button-sm">
                        Create <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-4 py-2 w-12">No</th>
                <th class="border-b border-t px-4 py-2 text-left">Upload Number</th>
                <th class="border-b border-t px-4 py-2 text-left">Customer Name</th>
                <th class="border-b border-t px-4 py-2 text-left">Booking Type</th>
                <th class="border-b border-t px-4 py-2 text-left">Upload Title</th>
                <th class="border-b border-t px-4 py-2 text-left">Status</th>
                <th class="border-b border-t px-4 py-2 text-right">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $uploadStatuses = [
                    'DRAFT' => 'bg-gray-200',
                    'SUBMITTED' => 'bg-orange-400',
                    'VALIDATED' => 'bg-green-500',
                ];
            ?>
            @forelse ($uploads as $index => $upload)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-1">{{ $upload->upload_number }}</td>
                    <td class="px-4 py-1">{{ $upload->customer->customer_name }}</td>
                    <td class="px-4 py-1">{{ $upload->bookingType->booking_name ?: '-' }}</td>
                    <td class="px-4 py-1">{{ $upload->upload_title ?: '-' }}</td>
                    <td class="px-4 py-1">
                        <span class="px-2 py-1 rounded text-xs {{ $upload->status == 'DRAFT' ? '' : 'text-white' }} {{ data_get($uploadStatuses, $upload->status, 'bg-gray-200') }}">
                            {{ $upload->status }}
                        </span>
                    </td>
                    <td class="px-4 py-1 text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                Action <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $upload)
                                    <a href="{{ route('uploads.show', ['upload' => $upload->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>View
                                    </a>
                                @endcan
                                @can('update', $upload)
                                    <a href="{{ route('uploads.edit', ['upload' => $upload->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-square-edit-outline mr-2"></i>Edit
                                    </a>
                                @endcan
                                @can('delete', $upload)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('uploads.validate', ['upload' => $upload->id]) }}" data-label="{{ $upload->upload_number }}" data-action="validate" class="dropdown-item confirm-submission">
                                        <i class="mdi mdi-check-all mr-2"></i>Validate
                                    </button>
                                    <button type="button" data-href="{{ route('uploads.destroy', ['upload' => $upload->id]) }}" data-label="{{ $upload->upload_number }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>Delete
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-4 py-2" colspan="7">No data available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="px-6">
            {{ $uploads->withQueryString()->links() }}
        </div>
    </div>

    @include('uploads.partials.modal-filter')
    @include('partials.modal-delete')
    @include('partials.modal-confirm')
@endsection
