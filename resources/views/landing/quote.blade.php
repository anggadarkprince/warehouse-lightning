@extends('layouts.landing')

@section('content')
    <div class="bg-gray-100 pt-10 pb-10">
        <div class="px-4 max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="font-bold text-3xl">Request a Quote</h1>
                <p class="text-gray-500">
                    Need dependable, cost effective transportation of your commodities?<br>
                    Fill out our easy Quote Request Form below to get a fast quote on your job.
                </p>
            </div>

            <form action="#" method="post">
                @csrf
                <div class="bg-white rounded-lg shadow-sm p-5 mb-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 md:gap-10">
                        <div class="col-span-1">
                            <h1 class="text-xl font-bold text-indigo-800">Personal Data</h1>
                            <p class="text-gray-500 mb-2">Your company and details</p>
                        </div>
                        <div class="col-span-2">
                            <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                <label for="company" class="mb-3 block font-semibold">{{ __('Company') }}</label>
                                <input id="company" name="company" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('company') border-red-500 @enderror"
                                       placeholder="Your company name" value="{{ old('company') }}" required autofocus maxlength="100" aria-label="company">
                                @error('company') <p class="form-text-error">{{ $message }}</p> @enderror
                            </div>
                            <div class="sm:flex -mx-2">
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="name" class="mb-3 block font-semibold">{{ __('Name') }}</label>
                                        <input id="name" name="name" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('name') border-red-500 @enderror"
                                               placeholder="Your first name" value="{{ old('name') }}" required maxlength="100" aria-label="name">
                                        @error('name') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="email" class="mb-3 block font-semibold">{{ __('Email') }}</label>
                                        <input id="email" name="email" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('name') border-red-500 @enderror"
                                               placeholder="Your email address" value="{{ old('email') }}" required maxlength="100" aria-label="email">
                                        @error('email') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="phone" class="mb-3 block font-semibold">{{ __('Phone') }}</label>
                                        <input id="phone" name="phone" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('name') border-red-500 @enderror"
                                               placeholder="Phone number / whatsapp" value="{{ old('phone') }}" required maxlength="100" aria-label="phone">
                                        @error('phone') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-5 mb-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 md:gap-10">
                        <div class="col-span-1">
                            <h1 class="text-xl font-bold text-indigo-800">Pickup Address</h1>
                            <p class="text-gray-500 mb-2">Check your pickup to delivery</p>
                        </div>
                        <div class="col-span-2">
                            <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                <label for="pickup_address" class="mb-3 block font-semibold">{{ __('Address') }}</label>
                                <input id="pickup_address" name="pickup_address" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('pickup_address') border-red-500 @enderror"
                                       placeholder="Where to pickup" value="{{ old('pickup_address') }}" required autofocus maxlength="200" aria-label="address">
                                @error('pickup_address') <p class="form-text-error">{{ $message }}</p> @enderror
                            </div>
                            <div class="sm:flex -mx-2">
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="pickup_country" class="mb-3 block font-semibold">{{ __('Country') }}</label>
                                        <input id="pickup_country" name="pickup_country" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('pickup_country') border-red-500 @enderror"
                                               placeholder="Country" value="{{ old('pickup_country') }}" required maxlength="50" aria-label="country">
                                        @error('pickup_country') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="pickup_city" class="mb-3 block font-semibold">{{ __('City') }}</label>
                                        <input id="pickup_city" name="pickup_city" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('pickup_city') border-red-500 @enderror"
                                               placeholder="City" value="{{ old('pickup_city') }}" required maxlength="50" aria-label="city">
                                        @error('pickup_city') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="pickup_zip" class="mb-3 block font-semibold">{{ __('Zip') }}</label>
                                        <input id="pickup_zip" name="pickup_zip" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('pickup_zip') border-red-500 @enderror"
                                               placeholder="Zip" value="{{ old('pickup_zip') }}" maxlength="50" aria-label="zip">
                                        @error('pickup_zip') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-5 mb-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 md:gap-10">
                        <div class="col-span-1">
                            <h1 class="text-xl font-bold text-indigo-800">Drop-Off Address</h1>
                            <p class="text-gray-500 mb-2">Check your pickup to delivery</p>
                        </div>
                        <div class="col-span-2">
                            <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                <label for="drop_off_address" class="mb-3 block font-semibold">{{ __('Address') }}</label>
                                <input id="drop_off_address" name="drop_off_address" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('drop_off_address') border-red-500 @enderror"
                                       placeholder="Where to deliver" value="{{ old('drop_off_address') }}" required autofocus maxlength="200" aria-label="address">
                                @error('drop_off_address') <p class="form-text-error">{{ $message }}</p> @enderror
                            </div>
                            <div class="sm:flex -mx-2">
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="drop_off_country" class="mb-3 block font-semibold">{{ __('Country') }}</label>
                                        <input id="drop_off_country" name="drop_off_country" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('drop_off_country') border-red-500 @enderror"
                                               placeholder="Country" value="{{ old('drop_off_country') }}" required maxlength="50" aria-label="country">
                                        @error('drop_off_country') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="drop_off_city" class="mb-3 block font-semibold">{{ __('City') }}</label>
                                        <input id="drop_off_city" name="drop_off_city" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('drop_off_city') border-red-500 @enderror"
                                               placeholder="City" value="{{ old('drop_off_city') }}" required maxlength="50" aria-label="city">
                                        @error('drop_off_city') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="drop_off_zip" class="mb-3 block font-semibold">{{ __('Zip') }}</label>
                                        <input id="drop_off_zip" name="drop_off_zip" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('drop_off_zip') border-red-500 @enderror"
                                               placeholder="Zip" value="{{ old('drop_off_zip') }}" maxlength="50" aria-label="zip">
                                        @error('drop_off_zip') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-5 mb-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 md:gap-10">
                        <div class="col-span-1">
                            <h1 class="text-xl font-bold text-indigo-800">Item To Be Shipped</h1>
                            <p class="text-gray-500 mb-2">Check your pickup to delivery</p>
                        </div>
                        <div class="col-span-2">
                            <div class="sm:flex -mx-2">
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="packaging" class="mb-3 block font-semibold">{{ __('Packaging') }}</label>
                                        <input id="packaging" name="packaging" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('packaging') border-red-500 @enderror"
                                               placeholder="Packaging" value="{{ old('packaging') }}" required maxlength="50" aria-label="packaging">
                                        @error('packaging') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="total_weight" class="mb-3 block font-semibold">{{ __('Total Weight (KG)') }}</label>
                                        <input id="total_weight" name="total_weight" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('total_weight') border-red-500 @enderror"
                                               placeholder="Total weight" value="{{ old('total_weight') }}" required maxlength="50" aria-label="city">
                                        @error('total_weight') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="quantity" class="mb-3 block font-semibold">{{ __('Quantity') }}</label>
                                        <input id="quantity" name="quantity" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('quantity') border-red-500 @enderror"
                                               placeholder="Quantity" value="{{ old('quantity') }}" required maxlength="50" aria-label="zip">
                                        @error('quantity') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="sm:flex -mx-2">
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="packaging" class="mb-3 block font-semibold">{{ __('Length') }}</label>
                                        <input id="length" name="length" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('length') border-red-500 @enderror"
                                               placeholder="Length" value="{{ old('length') }}" required maxlength="50" aria-label="packaging">
                                        @error('length') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="width" class="mb-3 block font-semibold">{{ __('Width') }}</label>
                                        <input id="width" name="width" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('width') border-red-500 @enderror"
                                               placeholder="Width" value="{{ old('width') }}" required maxlength="50" aria-label="city">
                                        @error('width') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="px-2 sm:w-1/3">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="height" class="mb-3 block font-semibold">{{ __('Height') }}</label>
                                        <input id="height" name="height" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('height') border-red-500 @enderror"
                                               placeholder="Height" value="{{ old('height') }}" required maxlength="50" aria-label="zip">
                                        @error('height') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 sm:mb-5">
                                <div class="flex flex-row">
                                    <div class="inline-block mr-8 flex items-center">
                                        <input type="radio" name="is_stackable" id="stackable" value="1" {{ old('stackable', 1) == '1' ? 'checked' : '' }}>
                                        <label for="stackable" class="ml-2">Stackable</label>
                                    </div>
                                    <div class="inline-block mr-8 flex items-center">
                                        <input type="radio" name="is_stackable" id="non_stackable" value="0" {{ old('stackable', 1) == '0' ? 'checked' : '' }}>
                                        <label for="non_stackable" class="ml-2">Non Stackable</label>
                                    </div>
                                </div>
                                @error('is_stackable') <p class="form-text-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-5">
                    <div class="flex justify-between items-center md:justify-end">
                        <a href="#" class="text-link mr-5"><i class="mdi mdi-information-outline mr-2"></i>Need assistance?</a>
                        <button type="submit" class="py-2 px-5 rounded bg-green-500 text-white transition duration-200 hover:bg-green-600">
                            Request Quote
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
