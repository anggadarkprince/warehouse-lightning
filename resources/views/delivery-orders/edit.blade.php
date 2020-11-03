@extends('layouts.app')

@section('content')
    <form action="{{ route('delivery-orders.update', ['delivery_order' => $deliveryOrder->id]) }}" method="post" id="form-delivery-order">
        @csrf
        @method('put')
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Edit Delivery Order</h1>
                <span class="text-gray-400">Manage delivery data</span>
            </div>
            <div class="py-2">
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="type" class="form-label">{{ __('Type') }}</label>
                            <div class="relative w-full">
                                <select class="form-input pr-8" name="type" id="type" required>
                                    <option value="">-- Select type --</option>
                                    <option value="INBOUND"{{ old('type', $deliveryOrder->type) == 'INBOUND' ? ' selected' : '' }}>
                                        INBOUND
                                    </option>
                                    <option value="OUTBOUND"{{ old('type', $deliveryOrder->type) == 'OUTBOUND' ? ' selected' : '' }}>
                                        OUTBOUND
                                    </option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>
                            @error('type') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="booking_id" class="form-label">{{ __('Booking') }}</label>
                            <div class="relative w-full">
                                <select class="form-input pr-8" name="booking_id" id="booking_id" required>
                                    <option value="">-- Select booking --</option>
                                    @foreach($bookings as $booking)
                                        <option value="{{ $booking->id }}" data-type="{{ $booking->bookingType->type }}"{{ old('booking_id', $deliveryOrder->booking_id) == $booking->id ? ' selected' : '' }}>
                                            {{ $booking->booking_number }} - {{ $booking->reference_number }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
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
                                   placeholder="Location name" value="{{ old('destination', $deliveryOrder->destination) }}" required maxlength="100">
                            @error('destination') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="delivery_date" class="form-label">{{ __('Delivery Date') }}</label>
                            <div class="relative w-full">
                                <input id="delivery_date" name="delivery_date" type="text" class="form-input datepicker @error('delivery_date') border-red-500 @enderror"
                                       placeholder="Date of delivery" value="{{ old('delivery_date', $deliveryOrder->delivery_date->format('d F Y')) }}" data-clear-button=".clear-delivery-date" required maxlength="20" autocomplete="off">
                                <span class="close absolute right-0 px-3 clear-delivery-date" style="top: 50%; transform: translateY(-50%)">&times;</span>
                            </div>
                            @error('delivery_date') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="destination_address" class="form-label">{{ __('Destination Address') }}</label>
                    <textarea id="destination_address" type="text" class="form-input @error('destination_address') border-red-500 @enderror"
                              placeholder="Location address" name="destination_address" maxlength="500">{{ old('destination_address', $deliveryOrder->destination_address) }}</textarea>
                    @error('destination_address') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="py-2">
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="driver_name" class="form-label">{{ __('Driver Name') }}</label>
                    <input id="driver_name" name="driver_name" type="text" class="form-input @error('driver_name') border-red-500 @enderror"
                           placeholder="Driver name" value="{{ old('driver_name', $deliveryOrder->driver_name) }}" required maxlength="50">
                    @error('driver_name') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/3">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="vehicle_name" class="form-label">{{ __('Vehicle Name') }}</label>
                            <input id="vehicle_name" name="vehicle_name" type="text" class="form-input @error('vehicle_name') border-red-500 @enderror"
                                   placeholder="Vehicle name" value="{{ old('vehicle_name', $deliveryOrder->vehicle_name) }}" required maxlength="50">
                            @error('vehicle_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/3">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="vehicle_type" class="form-label">{{ __('Vehicle Type') }}</label>
                            <input id="vehicle_type" name="vehicle_type" type="text" class="form-input @error('vehicle_type') border-red-500 @enderror"
                                   placeholder="Vehicle type" value="{{ old('vehicle_type', $deliveryOrder->vehicle_type) }}" maxlength="50">
                            @error('vehicle_type') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/3">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="vehicle_plat_number" class="form-label">{{ __('Vehicle Plat Number') }}</label>
                            <input id="vehicle_plat_number" name="vehicle_plat_number" type="text" class="form-input @error('vehicle_plat_number') border-red-500 @enderror"
                                   placeholder="Vehicle police plat number" value="{{ old('vehicle_plat_number', $deliveryOrder->vehicle_plat_number) }}" required maxlength="20">
                            @error('vehicle_plat_number') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                              placeholder="Delivery description" name="description">{{ old('description', $deliveryOrder->description) }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-primary button-sm">Save Delivery Order</button>
        </div>
    </form>
@endsection

