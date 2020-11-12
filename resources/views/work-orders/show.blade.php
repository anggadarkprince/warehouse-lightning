@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-3">
            <h1 class="text-xl text-green-500">{{ __('Work Order') }}</h1>
            <p class="text-gray-400 leading-tight">{{ __('Manage job data') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Job Number') }}</p>
                    <p class="text-gray-600">{{ $workOrder->job_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Job Type') }}</p>
                    <p class="text-gray-600">{{ $workOrder->job_type }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Customer') }}</p>
                    <p class="text-gray-600">{{ $workOrder->booking->customer->customer_name }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Reference Number') }}</p>
                    <p class="text-gray-600">{{ $workOrder->booking->reference_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Booking Number') }}</p>
                    <p class="text-gray-600">{{ $workOrder->booking->booking_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Assigned To') }}</p>
                    <p class="text-gray-600">{{ optional($workOrder->user)->name ?: '-' }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Taken At') }}</p>
                    <p class="text-gray-600">{{ optional($workOrder->taken_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Completed At') }}</p>
                    <p class="text-gray-600">{{ optional($workOrder->completed_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Status') }}</p>
                    <?php
                    $workOrderStatuses = [
                        'QUEUED' => 'bg-gray-200',
                        'TAKEN' => 'bg-orange-400',
                        'COMPLETED' => 'bg-blue-500',
                        'VALIDATED' => 'bg-green-500',
                        'REJECTED' => 'bg-red-500',
                    ];
                    ?>
                    <span class="px-2 py-1 rounded text-xs {{ $workOrder->status == 'QUEUED' ? '' : 'text-white' }} {{ data_get($workOrderStatuses, $workOrder->status, 'bg-gray-200') }}">
                        {{ $workOrder->status }}
                    </span>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Description') }}</p>
                    <p class="text-gray-600">{{ $workOrder->description ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Created At') }}</p>
                    <p class="text-gray-600">{{ optional($workOrder->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Updated At') }}</p>
                    <p class="text-gray-600">{{ optional($workOrder->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($workOrder->workOrderContainers()->exists())
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-3 flex items-center justify-between">
                <div>
                    <h1 class="text-xl text-green-500">{{ __('Containers') }}</h1>
                    <p class="text-gray-400 leading-tight">{{ __('List of job containers') }}</p>
                </div>
            </div>
            <table class="table-auto w-full mb-4">
                <thead>
                <tr>
                    <th class="border-b border-t px-2 py-2 w-12">{{ __('No') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Container Number') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Size') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Type') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Is Empty') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Seal') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Description') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($workOrder->workOrderContainers as $index => $workOrderContainer)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-2 py-1" style="min-width: 100px">
                            <a href="{{ route('containers.show', ['container' => $workOrderContainer->container->id]) }}" class="text-link">
                                {{ $workOrderContainer->container->container_number }}
                            </a>
                        </td>
                        <td class="px-2 py-1">{{ $workOrderContainer->container->container_size }}</td>
                        <td class="px-2 py-1">{{ $workOrderContainer->container->container_type }}</td>
                        <td class="px-2 py-1">{{ $workOrderContainer->is_empty ? 'Yes' : 'No' }}</td>
                        <td class="px-2 py-1">{{ $workOrderContainer->seal ?: '-' }}</td>
                        <td class="px-2 py-1">{{ $workOrderContainer->description ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-2 py-2">{{ __('No data available') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif

    @if($workOrder->workOrderGoods()->exists())
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-3 flex items-center justify-between">
                <div>
                    <h1 class="text-xl text-green-500">{{ __('Goods') }}</h1>
                    <p class="text-gray-400 leading-tight">{{ __('List of job goods') }}</p>
                </div>
            </div>
            <table class="table-auto w-full mb-4">
                <thead>
                <tr>
                    <th class="border-b border-t px-2 py-2 w-12">{{ __('No') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Item Name') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Quantity') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Package') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Weight') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Gross') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Description') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($workOrder->workOrderGoods as $index => $workOrderItem)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-2 py-1" style="min-width: 100px">
                            <a href="{{ route('goods.show', ['goods' => $workOrderItem->goods->id]) }}" class="text-link block leading-tight">
                                {{ $workOrderItem->goods->item_name }}
                            </a>
                            <span class="text-xs text-gray-500 leading-tight block">{{ $workOrderItem->goods->item_number }}</span>
                        </td>
                        <td class="px-2 py-1">
                            {{ numeric($workOrderItem->unit_quantity) }} {{ $workOrderItem->goods->unit_name }}
                        </td>
                        <td class="px-2 py-1">
                            {{ numeric($workOrderItem->package_quantity) }} {{ $workOrderItem->goods->package_name }}
                        </td>
                        <td class="px-2 py-1">{{ numeric($workOrderItem->weight) }} Kg</td>
                        <td class="px-2 py-1">{{ numeric($workOrderItem->gross_weight) }} Kg</td>
                        <td class="px-2 py-1">{{ $workOrderItem->description ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-2 py-2">{{ __('No data available') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-3 flex items-center justify-between">
            <div>
                <h1 class="text-xl text-green-500">{{ __('Status Histories') }}</h1>
                <p class="text-gray-400 leading-tight">{{ __('List of job statuses') }}</p>
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
            @forelse ($workOrder->statusHistories as $index => $statusHistory)
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
        <button type="button" onclick="history.back()" class="button-blue button-sm">{{ __('back') }}</button>
    </div>
@endsection
