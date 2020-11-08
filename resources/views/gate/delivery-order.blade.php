@extends('layouts.app')

@section('content')
    @include('gate.partials.scanner')

    <div class="bg-white rounded shadow py-4 mb-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">Delivery Order</h1>
                <span class="text-gray-400">Existing delivery order</span>
            </div>
        </div>
        <div class="px-6">
            <div class="sm:flex -mx-2">
                <div class="px-2 sm:w-1/2 md:w-1/3 text-center">
                    <div class="inline-block mx-auto border rounded p-4 my-4">
                        {!! QrCode::size(200)->generate($deliveryOrder->delivery_number); !!}
                    </div>
                </div>
                <div class="px-2 sm:w-1/2 md:w-3/4">
                    <div class="flex mb-2">
                        <p class="w-1/3 flex-shrink-0">{{ __('Delivery Number') }}</p>
                        <p class="text-gray-600">
                            <a href="{{ route('delivery-orders.show', ['delivery_order' => $deliveryOrder->id]) }}" class="text-link">
                                {{ $deliveryOrder->delivery_number }}
                            </a>
                        </p>
                    </div>
                    <div class="flex mb-2">
                        <p class="w-1/3 flex-shrink-0">{{ __('Type') }}</p>
                        <p class="text-gray-600">{{ $deliveryOrder->type }}</p>
                    </div>
                    <div class="flex mb-2">
                        <p class="w-1/3 flex-shrink-0">{{ __('Customer') }}</p>
                        <p class="text-gray-600">{{ $deliveryOrder->booking->customer->customer_name }}</p>
                    </div>
                    <div class="flex mb-2">
                        <p class="w-1/3 flex-shrink-0">{{ __('Reference Number') }}</p>
                        <p class="text-gray-600">{{ $deliveryOrder->booking->reference_number }}</p>
                    </div>
                    <div class="flex mb-2">
                        <p class="w-1/3 flex-shrink-0">{{ __('Delivery Date') }}</p>
                        <p class="text-gray-600">{{ $deliveryOrder->delivery_date->format('d F Y') }}</p>
                    </div>
                    <div class="flex mb-2">
                        <p class="w-1/3 flex-shrink-0">{{ __('Driver') }}</p>
                        <p class="text-gray-600">{{ $deliveryOrder->driver_name }}</p>
                    </div>
                    <div class="flex mb-2">
                        <p class="w-1/3 flex-shrink-0">{{ __('Vehicle') }}</p>
                        <p class="text-gray-600">{{ $deliveryOrder->vehicle_name }} {{ $deliveryOrder->vehicle_type }}</p>
                    </div>
                    <div class="flex mb-2">
                        <p class="w-1/3 flex-shrink-0">{{ __('Vehicle Plat') }}</p>
                        <p class="text-gray-600">{{ $deliveryOrder->vehicle_plat_number }}</p>
                    </div>
                    <div class="flex mb-2">
                        <p class="w-1/3 flex-shrink-0">{{ __('Destination') }}</p>
                        <p class="text-gray-600">{{ $deliveryOrder->destination }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2 flex justify-between items-center">
            <div>
                <h1 class="text-xl text-green-500">Containers</h1>
                <span class="text-gray-400">List of delivery container</span>
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

    <form action="#" method="post" id="form-gate">
        @csrf

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2 flex justify-between items-center">
                <div>
                    <h1 class="text-xl text-green-500">Goods</h1>
                    <span class="text-gray-400">List of delivery goods</span>
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
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Weight') }}</th>
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
@endsection
