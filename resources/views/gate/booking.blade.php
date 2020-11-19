@extends('layouts.app')

@section('content')
    @include('gate.partials.scanner')

    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-5 px-6">
            <div>
                <h1 class="text-xl text-green-500">Booking</h1>
                <p class="text-gray-400 leading-none">Existing booking</p>
            </div>
        </div>
        <div class="px-6">
            <div class="sm:flex -mx-2">
                <div class="px-2 w-auto hidden sm:block">
                    <div class="inline-block border rounded p-4 mb-3 sm:mb-0 sm:mr-2">
                        {!! QrCode::size(130)->generate($booking->booking_number); !!}
                    </div>
                </div>
                <div class="px-2 sm:w-2/3 md:w-full">
                    <div class="xl:flex -mx-2">
                        <div class="px-2 xl:w-7/12">
                            <div class="flex mb-2">
                                <p class="w-1/2 sm:w-1/3 flex-shrink-0">{{ __('Booking Number') }}</p>
                                <p class="text-gray-600">
                                    <a href="{{ route('bookings.show', ['booking' => $booking->id]) }}" class="text-link">
                                        {{ $booking->booking_number }}
                                    </a>
                                </p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 sm:w-1/3 flex-shrink-0">{{ __('Customer') }}</p>
                                <p class="text-gray-600">{{ $booking->customer->customer_name }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 sm:w-1/3 flex-shrink-0">{{ __('Booking Number') }}</p>
                                <p class="text-gray-600">{{ $booking->booking_number }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 sm:w-1/3 flex-shrink-0">{{ __('Reference Number') }}</p>
                                <p class="text-gray-600">{{ $booking->reference_number }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 sm:w-1/3 flex-shrink-0">{{ __('Voy Flight') }}</p>
                                <p class="text-gray-600">{{ $booking->voy_flight ?: '-' }}</p>
                            </div>
                        </div>
                        <div class="px-2 xl:flex-grow">
                            <div class="flex mb-2">
                                <p class="w-1/2 sm:w-1/3 flex-shrink-0">{{ __('Type') }}</p>
                                <p class="text-gray-600">{{ $booking->bookingType->type }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 sm:w-1/3 flex-shrink-0">{{ __('Arrival Date') }}</p>
                                <p class="text-gray-600">{{ optional($booking->arrival_date)->format('d M Y') ?: '-' }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 sm:w-1/3 flex-shrink-0">{{ __('Description') }}</p>
                                <p class="text-gray-600">{{ $booking->description ?: '-' }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 sm:w-1/3 flex-shrink-0">{{ __('Status') }}</p>
                                <p class="text-gray-600">{{ $booking->status }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 sm:w-1/3 flex-shrink-0">{{ __('Created At') }}</p>
                                <p class="text-gray-600">{{ $booking->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-4 flex justify-between items-center">
            <div>
                <h1 class="text-xl text-green-500">Booking Work Orders</h1>
                <p class="text-gray-400 leading-none">List of existing job related the booking</p>
            </div>
            <a href="{{ route('work-orders.create', ['booking_id' => $booking->id]) }}" class="button-blue button-sm" id="btn-toggle-unloading-job" title="Create unloading job from inbound delivery order">
                Create Job
            </a>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-2 py-2 w-12">{{ __('No') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Job Number') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Assigned To') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Job Type') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Taken At') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Completed At') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Status') }}</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $workOrderStatuses = [
                'QUEUED' => 'bg-gray-200',
                'TAKEN' => 'bg-orange-400',
                'COMPLETED' => 'bg-blue-500',
                'VALIDATED' => 'bg-green-500',
                'REJECTED' => 'bg-red-500',
            ];
            ?>
            @forelse($booking->workOrders as $index => $workOrder)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-2 py-1 text-left">{{ $workOrder->job_number }}</td>
                    <td class="px-2 py-1 text-left">{{ $workOrder->user->name }}</td>
                    <td class="px-2 py-1 text-left">{{ $workOrder->job_type }}</td>
                    <td class="px-2 py-1 text-left">{{ optional($workOrder->taken_at)->format('d M Y H:i') ?: '-' }}</td>
                    <td class="px-2 py-1 text-left">{{ optional($workOrder->completed_at)->format('d M Y H:i') ?: '-' }}</td>
                    <td class="px-2 py-1 text-left">
                        <span class="px-2 py-1 rounded text-xs {{ $workOrder->status == 'QUEUED' ? '' : 'text-white' }} {{ data_get($workOrderStatuses, $workOrder->status, 'bg-gray-200') }}">
                            {{ $workOrder->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-2">No data job available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
