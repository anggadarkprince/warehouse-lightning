@extends('layouts.app')

@section('content')
    @include('gate.partials.scanner')

    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-5 px-6">
            <div>
                <h1 class="text-xl text-green-500">Delivery Order</h1>
                <span class="text-gray-400 leading-none block">Existing delivery order</span>
            </div>
        </div>
        <div class="px-6">
            <div class="sm:flex -mx-2">
                <div class="px-2 w-auto hidden sm:block">
                    <div class="inline-block border rounded p-4 mb-3 sm:mb-0 sm:mr-2">
                        {!! QrCode::size(150)->generate($deliveryOrder->delivery_number); !!}
                    </div>
                </div>
                <div class="px-2 sm:w-2/3 md:w-full">
                    <div class="lg:flex -mx-2">
                        <div class="px-2 lg:w-1/2">
                            <div class="flex mb-2">
                                <p class="w-1/2 flex-shrink-0">{{ __('Delivery Number') }}</p>
                                <p class="text-gray-600">
                                    <a href="{{ route('delivery-orders.show', ['delivery_order' => $deliveryOrder->id]) }}" class="text-link">
                                        {{ $deliveryOrder->delivery_number }}
                                    </a>
                                </p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 flex-shrink-0">{{ __('Type') }}</p>
                                <p class="text-gray-600">{{ $deliveryOrder->type }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 flex-shrink-0">{{ __('Customer') }}</p>
                                <p class="text-gray-600">{{ $deliveryOrder->booking->customer->customer_name }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 flex-shrink-0">{{ __('Booking Number') }}</p>
                                <p class="text-gray-600" title="{{ $deliveryOrder->booking->reference_number }}">
                                    {{ $deliveryOrder->booking->booking_number }}
                                </p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 flex-shrink-0">{{ __('Delivery Date') }}</p>
                                <p class="text-gray-600">{{ $deliveryOrder->delivery_date->format('d M Y') }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 flex-shrink-0">{{ __('Created At') }}</p>
                                <p class="text-gray-600">{{ $deliveryOrder->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="px-2 lg:w-1/2">
                            <div class="flex mb-2">
                                <p class="w-1/2 flex-shrink-0">{{ __('Driver') }}</p>
                                <p class="text-gray-600">{{ $deliveryOrder->driver_name ?: '-' }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 flex-shrink-0">{{ __('Vehicle Name') }}</p>
                                <p class="text-gray-600">{{ $deliveryOrder->vehicle_name ?: '-' }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 flex-shrink-0">{{ __('Vehicle Type') }}</p>
                                <p class="text-gray-600">{{ $deliveryOrder->vehicle_type ?: '-' }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 flex-shrink-0">{{ __('Vehicle Plat') }}</p>
                                <p class="text-gray-600">{{ $deliveryOrder->vehicle_plat_number ?: '-' }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 flex-shrink-0">{{ __('Destination') }}</p>
                                <p class="text-gray-600">{{ $deliveryOrder->destination ?: '-' }}</p>
                            </div>
                            <div class="flex mb-2">
                                <p class="w-1/2 flex-shrink-0">{{ __('Address') }}</p>
                                <p class="text-gray-600">{{ $deliveryOrder->destination_address ?: '-' }}</p>
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
                <span class="text-gray-400 leading-none block">List of existing job related the booking</span>
            </div>
            <button class="button-blue button-sm" id="btn-toggle-unloading-job" title="Create unloading job from inbound delivery order">
                <i class="mdi mdi-file-replace-outline mr-1"></i>Create Unloading Job
            </button>
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
                'COMPLETED' => 'bg-green-500',
            ];
            ?>
            @forelse($deliveryOrder->booking->workOrders as $index => $workOrder)
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
                    <td colspan="7" class="px-2 py-1">No data job available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($deliveryOrder->type == 'INBOUND')
        <form action="{{ route('work-orders.store') }}" method="post" id="form-unloading-job" class="{{ empty(old('delivery_order_id')) ? 'hidden' : '' }}">
            @csrf
            <input type="hidden" name="delivery_order_id" value="{{ $deliveryOrder->id }}">
            <div class="bg-white rounded border border-green-500 shadow-sm px-6 py-4 mb-4">
                <div class="mb-3">
                    <h1 class="text-xl text-green-500">Create Job Unloading</h1>
                    <span class="text-gray-400 leading-none block">Convert delivery order to work order</span>
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="user_id" class="form-label">{{ __('Assigned Job User') }}</label>
                    <div class="relative w-full">
                        <select class="form-input pr-8" name="user_id" id="user_id">
                            <option value="">No specific user</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" data-type="{{ $user->name }}"{{ old('user_id') == $user->id ? ' selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                    @error('user_id') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                              placeholder="Job description or instruction" name="description">{{ old('description') }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
                <div class="mb-3 flex justify-between items-center">
                    <div>
                        <h1 class="text-xl text-green-500">Work Order Containers</h1>
                        <span class="text-gray-400 leading-none block">List of containers</span>
                    </div>
                    <button type="button" class="button-blue button-sm" id="btn-add-container" data-booking-id="{{ $deliveryOrder->booking_id }}" data-source-url="{{ route('bookings.containers.index', ['booking' => $deliveryOrder->booking_id]) }}">
                        ADD CONTAINER
                    </button>
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
                        <th class="border-b border-t px-2 py-2 text-left"></th>
                    </tr>
                    </thead>
                    <tbody id="container-wrapper">
                    <tr class="container-placeholder{{ empty(old('containers', $deliveryOrder->deliveryOrderContainers->toArray())) ? '' : ' hidden' }}">
                        <td colspan="8" class="px-4 py-2">{{ __('No data available') }}</td>
                    </tr>
                    @foreach(old('containers', $deliveryOrder->deliveryOrderContainers()->with('container')->get()->toArray()) as $index => $container)
                        @include('delivery-orders.partials.template-container-row', [
                            'index' => $index,
                            'containerOrder' => $index + 1,
                            'id' => data_get($container, 'id', ''),
                            'containerId' => data_get($container, 'container_id'),
                            'containerNumber' => data_get($container, 'container_number', data_get($container, 'container.container_number')),
                            'containerSize' => data_get($container, 'container_size', data_get($container, 'container.container_size')),
                            'containerType' => data_get($container, 'container_type', data_get($container, 'container.container_type')),
                            'isEmptyLabel' => data_get($container, 'is_empty') ? 'Yes' : 'No',
                            'isEmpty' => data_get($container, 'is_empty'),
                            'seal' => data_get($container, 'seal'),
                            'description' => data_get($container, 'description'),
                        ])
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
                <div class="mb-3 flex justify-between items-center">
                    <div>
                        <h1 class="text-xl text-green-500">Work Order Goods</h1>
                        <span class="text-gray-400 leading-none block">List of goods</span>
                    </div>
                    <button type="button" class="button-blue button-sm" id="btn-add-goods" data-booking-id="{{ $deliveryOrder->booking_id }}" data-source-url="{{ route('bookings.goods.index', ['booking' => $deliveryOrder->booking_id]) }}">
                        ADD GOODS
                    </button>
                </div>
                <table class="table-auto w-full mb-4">
                    <thead>
                    <tr>
                        <th class="border-b border-t px-4 py-2 w-12">{{ __('No') }}</th>
                        <th class="border-b border-t px-4 py-2 text-left">{{ __('Item Name') }}</th>
                        <th class="border-b border-t px-4 py-2 text-left">{{ __('Unit Name') }}</th>
                        <th class="border-b border-t px-4 py-2 text-left">{{ __('Unit Quantity') }}</th>
                        <th class="border-b border-t px-4 py-2 text-left">{{ __('Package Name') }}</th>
                        <th class="border-b border-t px-4 py-2 text-left">{{ __('Package Quantity') }}</th>
                        <th class="border-b border-t px-4 py-2 text-left">{{ __('Nett Weight') }}</th>
                        <th class="border-b border-t px-4 py-2 text-left">{{ __('Gross Weight') }}</th>
                        <th class="border-b border-t px-4 py-2 text-left">{{ __('Description') }}</th>
                        <th class="border-b border-t px-4 py-2 text-left"></th>
                    </tr>
                    </thead>
                    <tbody id="goods-wrapper">
                    <tr class="goods-placeholder{{ empty(old('goods', $deliveryOrder->deliveryOrderGoods->toArray())) ? '' : ' hidden' }}">
                        <td colspan="9" class="px-4 py-2">{{ __('No data available') }}</td>
                    </tr>
                    @foreach(old('goods', $deliveryOrder->deliveryOrderGoods()->with('goods')->get()->toArray()) as $index => $item)
                        @include('delivery-orders.partials.template-goods-row', [
                            'index' => $index,
                            'goodsOrder' => $index + 1,
                            'id' => data_get($item, 'id'),
                            'referenceId' => data_get($item, 'reference_id', data_get($item, 'booking_id', data_get($item, 'id'))),
                            'unitQuantityLabel' => numeric(data_get($item, 'unit_quantity')),
                            'packageQuantityLabel' => numeric(data_get($item, 'package_quantity')),
                            'weightLabel' => numeric(data_get($item, 'weight')),
                            'grossWeightLabel' => numeric(data_get($item, 'gross_weight')),
                            'goodsId' => data_get($item, 'goods_id'),
                            'itemName' => data_get($item, 'item_name', data_get($item, 'goods.item_name')),
                            'itemNumber' => data_get($item, 'item_number', data_get($item, 'goods.item_number')),
                            'unitName' => data_get($item, 'unit_name', data_get($item, 'goods.unit_name')),
                            'unitQuantity' => data_get($item, 'unit_quantity'),
                            'unitQuantityDefault' => data_get($item, 'unit_quantity'),
                            'packageName' => data_get($item, 'package_name', data_get($item, 'goods.package_name')),
                            'packageQuantity' => data_get($item, 'package_quantity'),
                            'packageQuantityDefault' => data_get($item, 'package_quantity'),
                            'weight' => data_get($item, 'weight'),
                            'weightDefault' => data_get($item, 'weight'),
                            'grossWeight' => data_get($item, 'gross_weight'),
                            'grossWeightDefault' => data_get($item, 'gross_weight'),
                            'description' => data_get($item, 'description'),
                            'actionDeleteOnly' => true
                        ])
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
                <button type="submit" class="button-primary button-sm ml-auto">Create Unloading Job</button>
            </div>
        </form>

        @include('delivery-orders.partials.modal-list-container')
        @include('delivery-orders.partials.modal-list-goods', ['actionDeleteOnly' => true])
        @include('partials.modal-info')
    @endif
@endsection
