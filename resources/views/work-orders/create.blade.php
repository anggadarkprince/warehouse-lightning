@extends('layouts.app')

@section('content')
    <form action="{{ route('work-orders.store') }}" method="post" id="form-gate">
        @csrf
        <input type="hidden" name="delivery_order_id" value="{{ optional($deliveryOrder)->id }}">
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Create Job</h1>
                <span class="text-gray-400">Manage job data</span>
            </div>
            <div class="flex flex-wrap mb-3 sm:mb-4">
                <label for="user_id" class="form-label">{{ __('Assigned Job User') }}</label>
                <div class="relative w-full">
                    <select class="form-input pr-8" name="user_id" id="user_id" required>
                        <option value="">-- Select user --</option>
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
