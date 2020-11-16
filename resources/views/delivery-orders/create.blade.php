@extends('layouts.app')

@section('content')
    <form action="{{ route('delivery-orders.store') }}" method="post" id="form-delivery-order">
        @csrf
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Create Delivery Order</h1>
                <span class="text-gray-400">Manage delivery data</span>
            </div>
            <div class="py-2">
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="type" class="form-label">{{ __('Delivery Type') }}</label>
                            <div class="w-full">
                                <select class="form-input select-choice" name="type" id="type" data-search-enable="false" required>
                                    <option value="">Select type</option>
                                    <option value="INBOUND"{{ old('type') == 'INBOUND' ? ' selected' : '' }}>
                                        INBOUND
                                    </option>
                                    <option value="OUTBOUND"{{ old('type') == 'OUTBOUND' ? ' selected' : '' }}>
                                        OUTBOUND
                                    </option>
                                </select>
                            </div>
                            @error('type') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="booking_id" class="form-label">{{ __('Booking') }}</label>
                            <div class="w-full">
                                <select class="form-input select-choice" name="booking_id" id="booking_id" required>
                                    <option value="">-- Select booking --</option>
                                    @foreach($bookings as $booking)
                                        <option value="{{ $booking->id }}" data-type="{{ $booking->bookingType->type }}"{{ old('booking_id') == $booking->id ? ' selected' : '' }}>
                                            {{ $booking->booking_number }} - {{ $booking->reference_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('booking_id') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Delivery Detail</h1>
                <span class="text-gray-400">Information about the booking</span>
            </div>
            <div class="py-2">
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="destination" class="form-label">{{ __('Destination') }}</label>
                            <input id="destination" name="destination" type="text" class="form-input @error('destination') border-red-500 @enderror"
                                   placeholder="Location name" value="{{ old('destination') }}" required maxlength="100">
                            @error('destination') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="delivery_date" class="form-label">{{ __('Delivery Date') }}</label>
                            <div class="relative w-full">
                                <input id="delivery_date" name="delivery_date" type="text" class="form-input datepicker @error('delivery_date') border-red-500 @enderror"
                                       placeholder="Date of delivery" value="{{ old('delivery_date') }}" data-clear-button=".clear-delivery-date" required maxlength="20" autocomplete="off">
                                <span class="close absolute right-0 px-3 clear-delivery-date" style="top: 50%; transform: translateY(-50%)">&times;</span>
                            </div>
                            @error('delivery_date') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="destination_address" class="form-label">{{ __('Destination Address') }}</label>
                    <textarea id="destination_address" type="text" class="form-input @error('destination_address') border-red-500 @enderror"
                              placeholder="Location address" name="destination_address" maxlength="500">{{ old('destination_address') }}</textarea>
                    @error('destination_address') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="py-2">
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="driver_name" class="form-label">{{ __('Driver Name') }}</label>
                    <input id="driver_name" name="driver_name" type="text" class="form-input @error('driver_name') border-red-500 @enderror"
                           placeholder="Driver name" value="{{ old('driver_name') }}" required maxlength="50">
                    @error('driver_name') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/3">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="vehicle_name" class="form-label">{{ __('Vehicle Name') }}</label>
                            <input id="vehicle_name" name="vehicle_name" type="text" class="form-input @error('vehicle_name') border-red-500 @enderror"
                                   placeholder="Vehicle name" value="{{ old('vehicle_name') }}" required maxlength="50">
                            @error('vehicle_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/3">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="vehicle_type" class="form-label">{{ __('Vehicle Type') }}</label>
                            <input id="vehicle_type" name="vehicle_type" type="text" class="form-input @error('vehicle_type') border-red-500 @enderror"
                                   placeholder="Vehicle type" value="{{ old('vehicle_type') }}" maxlength="50">
                            @error('vehicle_type') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/3">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="vehicle_plat_number" class="form-label">{{ __('Vehicle Plat Number') }}</label>
                            <input id="vehicle_plat_number" name="vehicle_plat_number" type="text" class="form-input @error('vehicle_plat_number') border-red-500 @enderror"
                                   placeholder="Police plat number" value="{{ old('vehicle_plat_number') }}" required maxlength="20">
                            @error('vehicle_plat_number') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                              placeholder="Delivery description" name="description">{{ old('description') }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2 flex justify-between items-center">
                <div>
                    <h1 class="text-xl text-green-500">Containers</h1>
                    <span class="text-gray-400">List of delivery container</span>
                </div>
                <button type="button" class="button-blue button-sm" id="btn-add-container">
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
                <tr class="container-placeholder{{ empty(old('containers', [])) ? '' : ' hidden' }}">
                    <td colspan="8" class="px-4 py-2">{{ __('No data available') }}</td>
                </tr>
                @foreach(old('containers', []) as $index => $container)
                    @include('delivery-orders.partials.template-container-row', [
                        'index' => $index,
                        'containerOrder' => $index + 1,
                        'containerId' => $container['container_id'],
                        'containerNumber' => $container['container_number'],
                        'containerSize' => $container['container_size'],
                        'containerType' => $container['container_type'],
                        'isEmptyLabel' => $container['is_empty'] ? 'Yes' : 'No',
                        'isEmpty' => $container['is_empty'],
                        'seal' => $container['seal'],
                        'description' => $container['description'],
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
                <button type="button" class="button-blue button-sm" id="btn-add-goods">
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
                <tr class="goods-placeholder{{ empty(old('goods', [])) ? '' : ' hidden' }}">
                    <td colspan="9" class="px-4 py-2">{{ __('No data available') }}</td>
                </tr>
                @foreach(old('goods', []) as $index => $item)
                    @include('delivery-orders.partials.template-goods-row', [
                        'index' => $index,
                        'goodsOrder' => $index + 1,
                        'referenceId' => $item['reference_id'],
                        'unitQuantityLabel' => numeric($item['unit_quantity']),
                        'packageQuantityLabel' => numeric($item['package_quantity']),
                        'weightLabel' => numeric($item['weight']),
                        'grossWeightLabel' => numeric($item['gross_weight']),
                        'goodsId' => $item['goods_id'],
                        'itemName' => $item['item_name'],
                        'itemNumber' => $item['item_number'],
                        'unitName' => $item['unit_name'],
                        'unitQuantity' => $item['unit_quantity'],
                        'packageName' => $item['package_name'],
                        'packageQuantity' => $item['package_quantity'],
                        'packageQuantityDefault' => $item['package_quantity'],
                        'weight' => $item['weight'],
                        'weightDefault' => $item['weight'],
                        'grossWeight' => $item['gross_weight'],
                        'grossWeightDefault' => $item['gross_weight'],
                        'description' => $item['description'],
                    ])
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-primary button-sm">Save Delivery Order</button>
        </div>
    </form>

    @include('delivery-orders.partials.modal-list-container')
    @include('delivery-orders.partials.modal-list-goods')
    @include('partials.modal-info')
@endsection

