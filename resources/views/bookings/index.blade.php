@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">Bookings</h1>
                <p class="text-gray-400 leading-tight">Manage booking data</p>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
                @can('create', \App\Models\Booking::class)
                    <a href="{{ route('bookings.import') }}" class="button-red button-sm">
                        Import <i class="mdi mdi-import"></i>
                    </a>
                    <a href="{{ route('bookings.create') }}" class="button-blue button-sm">
                        {{ __('Create') }} <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4 table-responsive">
            <thead>
            <tr>
                <th class="border-b border-t border-gray-200 p-2 w-12 md:text-center">No</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Reference Number</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Type</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Customer Name</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Booking Type</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Status</th>
                <th class="border-b border-t border-gray-200 p-2 md:text-right">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $bookingStatuses = [
                    'DRAFT' => 'bg-gray-200',
                    'VALIDATED' => 'bg-green-500',
                ];
            ?>
            @forelse ($bookings as $index => $booking)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-2 py-1 md:text-center">{{ $index + 1 }}</td>
                    <td class="px-2 py-1">
                        <p class="leading-none mt-1">{{ $booking->booking_number }}</p>
                        <p class="text-gray-500 text-xs leading-tight">{{ $booking->reference_number }}</p>
                    </td>
                    <td class="px-2 py-1">
                        <p class="leading-none mt-1">{{ $booking->bookingType->type ?: '-' }}</p>
                        <p class="text-gray-500 text-xs leading-tight">{{ optional($booking->upload)->upload_number ?: 'No upload' }}</p>
                    </td>
                    <td class="px-2 py-1">{{ $booking->customer->customer_name ?: '-' }}</td>
                    <td class="px-2 py-1">{{ $booking->bookingType->booking_name ?: '-' }}</td>
                    <td class="px-2 py-1">
                        <span class="px-2 py-1 rounded text-xs {{ $booking->getStatusClass() }}">
                            {{ $booking->status }}
                        </span>
                    </td>
                    <td class="px-2 py-1 md:text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                Action <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $booking)
                                    <a href="{{ route('bookings.show', ['booking' => $booking->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>View
                                    </a>
                                @endcan
                                @can('update', $booking)
                                    <a href="{{ route('bookings.edit', ['booking' => $booking->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-square-edit-outline mr-2"></i>Edit
                                    </a>
                                @endcan
                                @can('validate', $booking)
                                    @if($booking->status == \App\Models\Booking::STATUS_DRAFT)
                                        <button type="button" data-href="{{ route('bookings.validate', ['booking' => $booking->id]) }}" data-label="{{ $booking->booking_number }}" data-action="validate" class="dropdown-item confirm-submission">
                                            <i class="mdi mdi-check-all mr-2"></i>Validate
                                        </button>
                                    @endif
                                @endcan
                                @can('delete', $booking)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('bookings.destroy', ['booking' => $booking->id]) }}" data-label="{{ $booking->booking_number }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>Delete
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-2" colspan="7">No data available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="px-6">
            {{ $bookings->withQueryString()->links() }}
        </div>
    </div>

    @include('bookings.partials.modal-filter')
    @include('partials.modal-delete')
    @include('partials.modal-confirm')
@endsection
