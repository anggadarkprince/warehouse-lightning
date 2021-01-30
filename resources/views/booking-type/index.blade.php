@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm py-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">{{ __('Booking Type') }}</h1>
                <p class="text-gray-400 leading-tight">{{ __('Manage all booking type') }}</p>
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
                        {{ __('Create') }} <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4 table-responsive">
            <thead>
            <tr>
                <th class="border-b border-t p-2 border-gray-200 w-12 md:text-center">{{ __('No') }}</th>
                <th class="border-b border-t p-2 border-gray-200 text-left">{{ __('Booking Name') }}</th>
                <th class="border-b border-t p-2 border-gray-200 text-left">{{ __('Type') }}</th>
                <th class="border-b border-t p-2 border-gray-200 text-left">{{ __('Description') }}</th>
                <th class="border-b border-t p-2 border-gray-200 text-left">{{ __('Created At') }}</th>
                <th class="border-b border-t p-2 border-gray-200 md:text-right">{{ __('Action') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($bookingTypes as $index => $bookingType)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-2 py-1 md:text-center">{{ $index + 1 }}</td>
                    <td class="px-2 py-1">{{ $bookingType->booking_name }}</td>
                    <td class="px-2 py-1">{{ $bookingType->type }}</td>
                    <td class="px-2 py-1">{{ $bookingType->description ?: '-' }}</td>
                    <td class="px-2 py-1">{{ optional($bookingType->created_at)->format('d F Y H:i') }}</td>
                    <td class="px-2 py-1 md:text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                Action <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $bookingType)
                                    <a href="{{ route('booking-types.show', ['booking_type' => $bookingType->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>{{ __('View') }}
                                    </a>
                                @endcan
                                @can('update', $bookingType)
                                    <a href="{{ route('booking-types.edit', ['booking_type' => $bookingType->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-square-edit-outline mr-2"></i>{{ __('Edit') }}
                                    </a>
                                @endcan
                                @can('delete', $bookingType)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('booking-types.destroy', ['booking_type' => $bookingType->id]) }}" data-label="{{ $bookingType->booking_name }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>{{ __('Delete') }}
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-2" colspan="6">{{ __('No data available') }}</td>
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
