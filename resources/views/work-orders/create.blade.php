@extends('layouts.app')

@section('content')
    <form action="{{ route('work-orders.store') }}" method="post" id="form-work-order">
        @csrf
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-3">
                <h1 class="text-xl text-green-500">Create Work Order</h1>
                <p class="text-gray-400 leading-tight">Manage job data</p>
            </div>
            <div class="flex flex-wrap mb-3 sm:mb-4">
                <label for="booking_id" class="form-label">{{ __('Booking') }}</label>
                <div class="w-full">
                    @if(empty($selectedBooking))
                        <select class="form-input select-choice" name="booking_id" id="booking_id" required>
                            <option value="">Select booking</option>
                            @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}" data-type="{{ $booking->bookingType->type }}"{{ old('booking_id') == $booking->id ? ' selected' : '' }}>
                                    {{ $booking->booking_number }} - {{ $booking->reference_number }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="form-input">
                            {{ $selectedBooking->reference_number }} - {{ $selectedBooking->booking_number }} ({{ $selectedBooking->customer->customer_name }})
                        </p>
                        <input type="hidden" name="booking_id" id="booking_id" value="{{ $selectedBooking->id }}">
                    @endif
                </div>
                @error('booking_id') <p class="form-text-error">{{ $message }}</p> @enderror
            </div>
            <div class="sm:flex -mx-2">
                <div class="px-2 sm:w-1/2">
                    <div class="flex flex-wrap mb-3 sm:mb-4">
                        <label for="job_type" class="form-label">{{ __('Job Type') }}</label>
                        <div class="w-full">
                            <select class="form-input select-choice" name="job_type" id="job_type" required>
                                <option value="">No job type</option>
                                <option value="{{ \App\Models\WorkOrder::TYPE_UNLOADING }}"{{ old('job_type') == \App\Models\WorkOrder::TYPE_UNLOADING ? ' selected' : '' }}>
                                    {{ Str::of(\App\Models\WorkOrder::TYPE_UNLOADING)->replaceMatches('/[_-]/', ' ') }}
                                </option>
                                <option value="{{ \App\Models\WorkOrder::TYPE_STRIPPING_CONTAINER }}"{{ old('job_type') == \App\Models\WorkOrder::TYPE_STRIPPING_CONTAINER ? ' selected' : '' }}>
                                    {{ Str::of(\App\Models\WorkOrder::TYPE_STRIPPING_CONTAINER)->replaceMatches('/[_-]/', ' ') }}
                                </option>
                                <option value="{{ \App\Models\WorkOrder::TYPE_RETURN_EMPTY_CONTAINER }}"{{ old('job_type') == \App\Models\WorkOrder::TYPE_RETURN_EMPTY_CONTAINER ? ' selected' : '' }}>
                                    {{ Str::of(\App\Models\WorkOrder::TYPE_RETURN_EMPTY_CONTAINER)->replaceMatches('/[_-]/', ' ') }}
                                </option>
                                <option value="{{ \App\Models\WorkOrder::TYPE_UNPACKING_GOODS }}"{{ old('job_type') == \App\Models\WorkOrder::TYPE_UNPACKING_GOODS ? ' selected' : '' }}>
                                    {{ Str::of(\App\Models\WorkOrder::TYPE_UNPACKING_GOODS)->replaceMatches('/[_-]/', ' ') }}
                                </option>
                                <option value="{{ \App\Models\WorkOrder::TYPE_REPACKING_GOODS }}"{{ old('job_type') == \App\Models\WorkOrder::TYPE_REPACKING_GOODS ? ' selected' : '' }}>
                                    {{ Str::of(\App\Models\WorkOrder::TYPE_REPACKING_GOODS)->replaceMatches('/[_-]/', ' ') }}
                                </option>
                                <option value="{{ \App\Models\WorkOrder::TYPE_LOADING }}"{{ old('job_type') == \App\Models\WorkOrder::TYPE_LOADING ? ' selected' : '' }}>
                                    {{ Str::of(\App\Models\WorkOrder::TYPE_LOADING)->replaceMatches('/[_-]/', ' ') }}
                                </option>
                            </select>
                        </div>
                        @error('user_id') <p class="form-text-error">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="px-2 sm:w-1/2">
                    <div class="flex flex-wrap mb-3 sm:mb-4">
                        <label for="user_id" class="form-label">{{ __('Assigned Job User') }}</label>
                        <div class="w-full">
                            <select class="form-input" name="user_id" id="user_id">
                                <option value="">No assigned user</option>
                                <option value="0"{{ old('user_id') == '0' ? ' selected' : '' }}>
                                    No specific user (let user take the job)
                                </option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" data-custom-properties='{"avatar": "{{ $user->avatar }}", "email": "{{ $user->email }}"}'
                                        {{ old('user_id') == $user->id ? ' selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('user_id') <p class="form-text-error">{{ $message }}</p> @enderror
                    </div>
                </div>
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
                    <h1 class="text-xl text-green-500">Containers</h1>
                    <p class="text-gray-400 leading-tight">List of containers</p>
                </div>
                <button type="button" class="button-blue button-sm" id="btn-add-container" data-booking-id="{{ optional($selectedBooking)->id }}" data-source-url="{{ route('bookings.containers.index', ['booking' => optional($selectedBooking)->id ?: '0']) }}">
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
                    <h1 class="text-xl text-green-500">Goods</h1>
                    <p class="text-gray-400 leading-tight">List of goods</p>
                </div>
                <button type="button" class="button-blue button-sm" id="btn-add-goods" data-booking-id="{{ optional($selectedBooking)->id }}" data-source-url="{{ route('bookings.goods.index', ['booking' => optional($selectedBooking)->id ?: '0']) }}">
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
                <tr class="goods-placeholder{{ empty(old('goods', [])) ? '' : ' hidden' }}">
                    <td colspan="9" class="px-4 py-2">{{ __('No data available') }}</td>
                </tr>
                @foreach(old('goods', []) as $index => $item)
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
            <button type="submit" class="button-primary button-sm ml-auto">Create Work Order</button>
        </div>
    </form>

    @include('delivery-orders.partials.modal-list-container')
    @include('delivery-orders.partials.modal-list-goods', ['actionDeleteOnly' => true])
    @include('partials.modal-info')
@endsection
