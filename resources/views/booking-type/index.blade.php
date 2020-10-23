@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow py-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">Booking Type</h1>
                <span class="text-gray-400">Manage all booking type</span>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
                @can('create', \App\Models\BookingType::class)
                    <a href="{{ route('booking-types.create') }}" class="button-blue button-sm">
                        Create <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-4 py-2 w-12">No</th>
                <th class="border-b border-t px-4 py-2 text-left">Booking Type</th>
                <th class="border-b border-t px-4 py-2 text-left">Description</th>
                <th class="border-b border-t px-4 py-2 text-left">Created At</th>
                <th class="border-b border-t px-4 py-2 text-right">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($bookingTypes as $index => $bookingType)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-1">{{ $bookingType->booking_name }}</td>
                    <td class="px-4 py-1">{{ $bookingType->description ?: '-' }}</td>
                    <td class="px-4 py-1">{{ optional($bookingType->created_at)->format('d F Y H:i') }}</td>
                    <td class="px-4 py-1 text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                Action <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $bookingType)
                                    <a href="{{ route('booking-types.show', ['booking_type' => $bookingType->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>View
                                    </a>
                                @endcan
                                @can('update', $bookingType)
                                <a href="{{ route('booking-types.edit', ['booking_type' => $bookingType->id]) }}" class="dropdown-item">
                                    <i class="mdi mdi-square-edit-outline mr-2"></i>Edit
                                </a>
                                @endcan
                                @can('delete', $bookingType)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('booking-types.destroy', ['booking_type' => $bookingType->id]) }}" data-label="{{ $bookingType->booking_name }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>Delete
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No data available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="px-6">
            {{ $bookingTypes->withQueryString()->links() }}
        </div>
    </div>

    @include('booking-type.partials.modal-filter')
    @include('partials.modal-delete')
@endsection
