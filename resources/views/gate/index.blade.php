@extends('layouts.app')

@section('content')
    @include('gate.partials.scanner')

    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">Work Orders</h1>
                <p class="text-gray-400 leading-tight">Manage job data</p>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
                @can('create', \App\Models\WorkOrder::class)
                    <a href="{{ route('work-orders.create') }}" class="button-blue button-sm">
                        Create <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4 table-responsive">
            <thead>
            <tr>
                <th class="border-b border-t border-gray-200 p-2 w-12 md:text-center">No</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Job Number</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Booking</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Customer</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Assigned To</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Completed At</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">Status</th>
                <th class="border-b border-t border-gray-200 p-2 md:text-right">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($workOrders as $index => $workOrder)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-2 py-1 md:text-center">{{ $index + 1 }}</td>
                    <td class="px-2 py-1">
                        <p>{{ $workOrder->job_number }}</p>
                        <p class="text-gray-500 text-xs leading-tight">{{ $workOrder->job_type }}</p>
                    </td>
                    <td class="px-2 py-1">
                        <p>
                            <a class="text-link" href="{{ route('bookings.show', ['booking' => $workOrder->booking_id]) }}">
                                {{ $workOrder->booking->booking_number }}
                            </a>
                        </p>
                        <p class="text-gray-500 text-xs leading-tight">{{ $workOrder->booking->reference_number }}</p>
                    </td>
                    <td class="px-2 py-1">{{ $workOrder->booking->customer->customer_name ?: '-' }}</td>
                    <td class="px-2 py-1">{{ optional($workOrder->user)->name ?: '-' }}</td>
                    <td class="px-2 py-1">{{ optional($workOrder->completed_at)->format('d M Y  H:i') ?: '-' }}</td>
                    <td class="px-2 py-1">
                        <span class="px-2 py-1 rounded text-xs {{ $workOrder->getStatusClass() }}">
                            {{ $workOrder->status }}
                        </span>
                    </td>
                    <td class="px-2 py-1 md:text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                Action <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $workOrder)
                                    <a href="{{ route('work-orders.show', ['work_order' => $workOrder->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>View
                                    </a>
                                    <a href="{{ route('work-orders.print', ['work_order' => $workOrder->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-file-pdf-outline mr-2"></i>Print
                                    </a>
                                @endcan
                                @can('update', $workOrder)
                                    <a href="{{ route('work-orders.edit', ['work_order' => $workOrder->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-square-edit-outline mr-2"></i>Edit
                                    </a>
                                @endcan
                                @can('delete', $workOrder)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('work-orders.destroy', ['work_order' => $workOrder->id]) }}" data-label="{{ $workOrder->job_number }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>Delete
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-2" colspan="8">No data available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="px-6">
            {{ $workOrders->withQueryString()->links() }}
        </div>
    </div>

    @include('work-orders.partials.modal-filter')
    @include('partials.modal-delete')
@endsection
