@extends('layouts.app')

@section('content')
    <form action="{{ route('bookings.store') }}" method="post" id="form-booking">
        @csrf
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Create Booking</h1>
                <span class="text-gray-400">Manage booking data</span>
            </div>
            <div class="py-2">
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="upload_id" class="form-label">{{ __('Upload') }}</label>
                    <div class="relative w-full">
                        <select class="form-input pr-8" name="upload_id" id="upload_id">
                            <option value="">-- Select upload --</option>
                            @foreach($uploads as $upload)
                                <option value="{{ $upload->id }}"{{ old('upload_id') == $upload->id ? ' selected' : '' }}>
                                    {{ $upload->upload_number }} - {{ $upload->customer->customer_name }} ({{ $upload->upload_title }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                    @error('upload_id') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="customer_id" class="form-label">{{ __('Customer') }}</label>
                            <div class="relative w-full">
                                <select class="form-input pr-8" name="customer_id" id="customer_id">
                                    <option value="">-- Select customer --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}"{{ old('customer_id') == $customer->id ? ' selected' : '' }}>
                                            {{ $customer->customer_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>
                            @error('customer_id') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="booking_type_id" class="form-label">{{ __('Booking Type') }}</label>
                            <div class="relative w-full">
                                <select class="form-input pr-8" name="booking_type_id" id="booking_type_id">
                                    <option value="">-- Select booking type --</option>
                                    @foreach($bookingTypes as $bookingType)
                                        <option value="{{ $bookingType->id }}"{{ old('booking_type_id') == $bookingType->id ? ' selected' : '' }}>
                                            {{ $bookingType->type }} - {{ $bookingType->booking_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>
                            @error('booking_type_id') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Booking Detail</h1>
                <span class="text-gray-400">Information about the booking</span>
            </div>
            <div class="py-2">
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="reference_number" class="form-label">{{ __('Reference Number') }}</label>
                    <input id="reference_number" name="reference_number" type="text" class="form-input @error('reference_number') border-red-500 @enderror"
                           placeholder="Reference number" value="{{ old('reference_number') }}" required maxlength="100">
                    @error('reference_number') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="supplier_name" class="form-label">{{ __('Supplier Name') }}</label>
                            <input id="supplier_name" name="supplier_name" type="text" class="form-input @error('supplier_name') border-red-500 @enderror"
                                   placeholder="Reference number" value="{{ old('supplier_name') }}" required maxlength="100">
                            @error('supplier_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="owner_name" class="form-label">{{ __('Owner Name') }}</label>
                            <input id="owner_name" name="owner_name" type="text" class="form-input @error('owner_name') border-red-500 @enderror"
                                   placeholder="Owner name" value="{{ old('owner_name') }}" required maxlength="100">
                            @error('owner_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="shipper_name" class="form-label">{{ __('Shipper Name') }}</label>
                            <input id="shipper_name" name="shipper_name" type="text" class="form-input @error('shipper_name') border-red-500 @enderror"
                                   placeholder="Shipper name" value="{{ old('shipper_name') }}" required maxlength="100">
                            @error('shipper_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="voy_flight" class="form-label">{{ __('Voy Flight') }}</label>
                            <input id="voy_flight" name="voy_flight" type="text" class="form-input @error('voy_flight') border-red-500 @enderror"
                                   placeholder="Voy flight number" value="{{ old('voy_flight') }}" required maxlength="50">
                            @error('voy_flight') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="arrival_date" class="form-label">{{ __('Arrival Date') }}</label>
                            <div class="relative w-full">
                                <input id="arrival_date" name="arrival_date" type="text" class="form-input datepicker @error('arrival_date') border-red-500 @enderror"
                                       placeholder="ATA of delivery" value="{{ old('arrival_date') }}" data-clear-button=".clear-ata" maxlength="20" autocomplete="off">
                                <span class="close absolute right-0 px-3 clear-ata" style="top: 50%; transform: translateY(-50%)">&times;</span>
                            </div>
                            @error('arrival_date') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="tps" class="form-label">{{ __('TPS') }}</label>
                            <input id="tps" name="tps" type="text" class="form-input @error('tps') border-red-500 @enderror"
                                   placeholder="TPS of destination" value="{{ old('tps') }}" required maxlength="50">
                            @error('tps') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="py-2">
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="total_cif" class="form-label">{{ __('Total CIF') }}</label>
                    <input id="total_cif" name="total_cif" type="text" class="form-input input-numeric @error('total_cif') border-red-500 @enderror"
                           placeholder="Total CIF of goods" value="{{ old('total_cif') }}" required maxlength="50">
                    @error('total_cif') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                              placeholder="Booking description" name="description">{{ old('description') }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2 flex justify-between items-center">
                <div>
                    <h1 class="text-xl text-green-500">Containers</h1>
                    <span class="text-gray-400">List of booking container</span>
                </div>
                <button type="button" class="button-blue button-sm" id="btn-add-container">
                    ADD CONTAINER
                </button>
            </div>
            <table class="table-auto w-full mb-4">
                <thead>
                <tr>
                    <th class="border-b border-t px-4 py-2 w-12">{{ __('No') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Container Number') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Size') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Type') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Is Empty') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Seal') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Description') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left"></th>
                </tr>
                </thead>
                <tbody id="container-wrapper">
                    <tr class="container-placeholder{{ empty(old('containers', [])) ? '' : 'hidden' }}">
                        <td colspan="8" class="px-4 py-2">{{ __('No data available') }}</td>
                    </tr>
                    @foreach(old('containers', []) as $index => $container)
                        @include('bookings.partials.template-container-row', [
                            'containerNumber' => $container['container_number'],
                            'containerSize' => $container['container_size'],
                            'containerType' => $container['container_type'],
                            'isEmptyLabel' => $container['is_empty'] ? 'Yes' : 'No',
                            'isEmpty' => $container['is_empty'],
                            'seal' => $container['seal'],
                            'description' => $container['description'],
                            'containerId' => $container['container_id'],
                            'index' => $index,
                        ])
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2 flex justify-between items-center">
                <div>
                    <h1 class="text-xl text-green-500">Goods</h1>
                    <span class="text-gray-400">List of booking goods</span>
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
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Description') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left"></th>
                </tr>
                </thead>
                <tbody id="goods-wrapper">
                <tr class="goods-placeholder{{ empty(old('goods', [])) ? '' : 'hidden' }}">
                    <td colspan="9" class="px-4 py-2">{{ __('No data available') }}</td>
                </tr>
                @foreach(old('goods', []) as $index => $item)
                    @include('bookings.partials.template-goods-row', [
                        'unitQuantityLabel' => numeric($item['unit_quantity']),
                        'packageQuantityLabel' => numeric($item['package_quantity']),
                        'weightLabel' => numeric($item['weight']),
                        'goodsId' => $item['goods_id'],
                        'itemName' => $item['item_name'],
                        'itemNumber' => $item['item_number'],
                        'unitName' => $item['unit_name'],
                        'unitQuantity' => $item['unit_quantity'],
                        'packageName' => $item['package_name'],
                        'packageQuantity' => $item['package_quantity'],
                        'weight' => $item['weight'],
                        'description' => $item['description'],
                        'index' => $index,
                    ])
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-primary button-sm">Save Booking</button>
        </div>
    </form>

    @include('bookings.partials.modal-form-container')
    @include('bookings.partials.modal-form-goods')
    @include('partials.modal-info')
@endsection

