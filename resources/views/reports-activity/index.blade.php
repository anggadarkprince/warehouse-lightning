@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">{{ $reportType }} Containers</h1>
                <p class="text-gray-400 leading-tight">Manage {{ strtolower($reportType) }} data</p>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter-container">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1, 'filter' => 'container']) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
            </div>
        </div>
        <div class="overflow-x-scroll">
            <table class="table-auto w-full mb-4 whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="border-b border-t px-3 py-2 w-12">No</th>
                    <th class="border-b border-t px-3 py-2 text-left">Reference Number</th>
                    <th class="border-b border-t px-3 py-2 text-left">Booking Number</th>
                    <th class="border-b border-t px-3 py-2 text-left">Customer</th>
                    <th class="border-b border-t px-3 py-2 text-left">Booking Name</th>
                    <th class="border-b border-t px-3 py-2 text-left">Job Number</th>
                    <th class="border-b border-t px-3 py-2 text-left">Assigned To</th>
                    <th class="border-b border-t px-3 py-2 text-left">Completed At</th>
                    <th class="border-b border-t px-3 py-2 text-left">Container Number</th>
                    <th class="border-b border-t px-3 py-2 text-left">Container Type</th>
                    <th class="border-b border-t px-3 py-2 text-left">Container Size</th>
                    <th class="border-b border-t px-3 py-2 text-left">Is Empty</th>
                    <th class="border-b border-t px-3 py-2 text-left">Description</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($activityContainers as $index => $activity)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-3 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-3 py-1">{{ $activity->workOrder->booking->reference_number }}</td>
                        <td class="px-3 py-1">{{ $activity->workOrder->booking->booking_number }}</td>
                        <td class="px-3 py-1">{{ $activity->workOrder->booking->customer->customer_name ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $activity->workOrder->booking->bookingType->booking_name ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $activity->workOrder->job_number }}</td>
                        <td class="px-3 py-1">{{ $activity->workOrder->user->name ?: '-' }}</td>
                        <td class="px-3 py-1">{{ optional($activity->workOrder->completed_at)->format('d F Y H:i:s') ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $activity->container->container_number ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $activity->container->container_type ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $activity->container->container_size ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $activity->is_empty ? 'Yes' : 'No' }}</td>
                        <td class="px-3 py-1">{{ $activity->description ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-3 py-2" colspan="13">No data available</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6">
            {{ $activityContainers->withQueryString()->links() }}
        </div>
    </div>

    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">{{ $reportType }} Goods</h1>
                <p class="text-gray-400 leading-tight">Manage {{ strtolower($reportType) }} data</p>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter-goods">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1, 'filter' => 'goods']) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
            </div>
        </div>
        <div class="overflow-x-scroll">
            <table class="table-auto w-full mb-4 whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="border-b border-t px-3 py-2 w-12">No</th>
                    <th class="border-b border-t px-3 py-2 text-left">Reference Number</th>
                    <th class="border-b border-t px-3 py-2 text-left">Booking Number</th>
                    <th class="border-b border-t px-3 py-2 text-left">Customer</th>
                    <th class="border-b border-t px-3 py-2 text-left">Booking Name</th>
                    <th class="border-b border-t px-3 py-2 text-left">Job Number</th>
                    <th class="border-b border-t px-3 py-2 text-left">Assigned To</th>
                    <th class="border-b border-t px-3 py-2 text-left">Completed At</th>
                    <th class="border-b border-t px-3 py-2 text-left">Item Number</th>
                    <th class="border-b border-t px-3 py-2 text-left">Item Name</th>
                    <th class="border-b border-t px-3 py-2 text-left">Quantity</th>
                    <th class="border-b border-t px-3 py-2 text-left">Package</th>
                    <th class="border-b border-t px-3 py-2 text-left">Weight</th>
                    <th class="border-b border-t px-3 py-2 text-left">Gross</th>
                    <th class="border-b border-t px-3 py-2 text-left">Description</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($activityGoods as $index => $activity)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-3 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-3 py-1">{{ $activity->workOrder->booking->reference_number }}</td>
                        <td class="px-3 py-1">{{ $activity->workOrder->booking->booking_number }}</td>
                        <td class="px-3 py-1">{{ $activity->workOrder->booking->customer->customer_name ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $activity->workOrder->booking->bookingType->booking_name ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $activity->workOrder->job_number }}</td>
                        <td class="px-3 py-1">{{ $activity->workOrder->user->name ?: '-' }}</td>
                        <td class="px-3 py-1">{{ optional($activity->workOrder->completed_at)->format('d F Y H:i:s') ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $activity->goods->item_number ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $activity->goods->item_name ?: '-' }}</td>
                        <td class="px-3 py-1">{{ numeric($activity->unit_quantity) }} {{ $activity->goods->unit_name }}</td>
                        <td class="px-3 py-1">{{ numeric($activity->package_quantity) }} {{ $activity->goods->package_name }}</td>
                        <td class="px-3 py-1">{{ numeric($activity->weight) }} Kg</td>
                        <td class="px-3 py-1">{{ numeric($activity->gross_weight) }} Kg</td>
                        <td class="px-3 py-1">{{ $activity->description ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-3 py-2" colspan="15">No data available</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6">
            {{ $activityGoods->withQueryString()->links() }}
        </div>
    </div>

    @include('reports-activity.partials.modal-filter-container')
    @include('reports-activity.partials.modal-filter-goods')
@endsection
