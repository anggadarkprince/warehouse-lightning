@extends('layouts.landing')

@section('content')
    <div class="bg-gray-100 pt-10 pb-10">
        <div class="px-4 max-w-4xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="font-bold text-3xl">Track & Trace</h1>
                <p class="text-gray-500">
                    Find your shipment location just in time?<br>
                    Trace history of delivery in details.
                </p>
            </div>

            <form action="#" method="get">
                <div class="bg-white rounded-lg shadow-sm p-5 mb-5">
                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                        <label for="shipment_type" class="mb-3 block font-semibold">{{ __('Shipment Type') }}</label>
                        <div class="relative w-full">
                            <select id="shipment_type" name="shipment_type" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('shipment_type') border-red-500 @enderror"
                                    required autofocus aria-label="shipment">
                                <option value="">Select Type</option>
                                <option value="company"{{ old('shipment_type') == 'employee' ? ' selected' : '' }}>Company</option>
                                <option value="personal"{{ old('shipment_type') == 'personal' ? ' selected' : '' }}>Personal Delivery</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                        @error('shipment_type') <p class="form-text-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                        <label for="tracking_number" class="mb-3 block font-semibold">{{ __('Tracking Number') }}</label>
                        <textarea id="tracking_number" name="tracking_number" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('tracking_number') border-red-500 @enderror"
                                  placeholder="You can enter up to a maximum of 10 airway bill numbers for tracking (separated by comma)." required autofocus aria-label="tracking number">{{ old('tracking_number') }}</textarea>
                        @error('tracking_number') <p class="form-text-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-3 sm:mb-5">
                        <div class="flex flex-row">
                            <div class="inline-block mr-8 flex items-center">
                                <input type="radio" name="type" id="air_freight" value="air_freight"{{ old('type') == 'air_freight' ? ' checked' : '' }} required>
                                <label for="air_freight" class="ml-2 font-semibold">Air Freight</label>
                            </div>
                            <div class="inline-block mr-8 flex items-center">
                                <input type="radio" name="type" id="ocean_freight" value="ocean_freight"{{ old('type') == 'ocean_freight' ? ' checked' : '' }}>
                                <label for="ocean_freight" class="ml-2 font-semibold">Ocean Freight</label>
                            </div>
                            <div class="inline-block mr-8 flex items-center">
                                <input type="radio" name="type" id="road_freight" value="road_freight"{{ old('type') == 'road_freight' ? ' checked' : '' }}>
                                <label for="road_freight" class="ml-2 font-semibold">Road Freight</label>
                            </div>
                            <div class="inline-block mr-8 flex items-center">
                                <input type="radio" name="type" id="express_delivery" value="express_delivery"{{ old('type') == 'express_delivery' ? ' checked' : '' }}>
                                <label for="express_delivery" class="ml-2 font-semibold">Express Delivery</label>
                            </div>
                        </div>
                        @error('type') <p class="form-text-error">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-5">
                    <button type="submit" class="block w-full py-3 px-5 rounded bg-blue-900 text-white transition duration-200 hover:bg-green-600">
                        Track & Trace
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
