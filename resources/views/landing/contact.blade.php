@extends('layouts.landing')

@section('content')
    <div class="bg-gray-100 pt-10 pb-10">
        <div class="px-4 max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="font-bold text-3xl">Contact Us</h1>
                <p class="text-gray-500">Any question or remarks? Just write us a message!</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-3 md:pr-5">
                <div class="grid grid-cols-1 md:gap-10 md:grid-cols-3">
                    <div class="col-span-2 mb-10 md:mb-0 py-4">
                        <form action="#" method="post">
                            @csrf
                            <div class="sm:flex -mx-2">
                                <div class="px-2 sm:w-1/2">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="first_name" class="mb-3 block font-bold">{{ __('First Name') }}</label>
                                        <input id="first_name" name="first_name" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('name') border-red-500 @enderror"
                                               placeholder="Your first name" value="{{ old('first_name') }}" required maxlength="100" aria-label="name">
                                        @error('first_name') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="px-2 sm:w-1/2">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="last_name" class="mb-3 block font-bold">{{ __('Last Name') }}</label>
                                        <input id="last_name" name="last_name" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('name') border-red-500 @enderror"
                                               placeholder="Your last name" value="{{ old('last_name') }}" required maxlength="100" aria-label="name">
                                        @error('last_name') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="sm:flex -mx-2">
                                <div class="px-2 sm:w-1/2">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="email" class="mb-3 block font-bold">{{ __('Email') }}</label>
                                        <input id="email" name="email" type="email" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('email') border-red-500 @enderror"
                                               placeholder="Email address" value="{{ old('email') }}" required maxlength="100" aria-label="name">
                                        @error('email') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="px-2 sm:w-1/2">
                                    <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                        <label for="phone" class="mb-3 block font-bold">{{ __('Phone') }}</label>
                                        <input id="phone" name="phone" type="text" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('phone') border-red-500 @enderror"
                                               placeholder="Phone number" value="{{ old('phone') }}" required maxlength="100" aria-label="name">
                                        @error('phone') <p class="form-text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 sm:mb-5">
                                <label for="service" class="mb-2 block font-bold">{{ __('What the of service do you need?') }}</label>
                                <div>
                                    <div class="inline-block mr-4">
                                        <input type="checkbox" name="service_air_freight" id="service_air_freight">
                                        <label for="service_air_freight">Air Freight</label>
                                    </div>
                                    <div class="inline-block mr-4">
                                        <input type="checkbox" name="service_ocean_freight" id="service_ocean_freight">
                                        <label for="service_ocean_freight">Ocean Freight</label>
                                    </div>
                                    <div class="inline-block mr-4">
                                        <input type="checkbox" name="service_road_freight" id="service_road_freight">
                                        <label for="service_road_freight">Road Freight</label>
                                    </div>
                                    <div class="inline-block mr-4">
                                        <input type="checkbox" name="service_warehousing" id="service_warehousing">
                                        <label for="service_warehousing">Warehousing</label>
                                    </div>
                                </div>
                                @error('message') <p class="form-text-error">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3 sm:mb-5 focus-within:text-green-500">
                                <label for="message" class="mb-3 block font-bold">{{ __('Message') }}</label>
                                <textarea id="message" class="text-black bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:mb-0 focus:border-green-500 @error('message') border-red-500 @enderror"
                                          placeholder="Your message" name="description" required>{{ old('message') }}</textarea>
                                @error('message') <p class="form-text-error">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex justify-between items-center mt-8">
                                <a href="#" class="text-link"><i class="mdi mdi-information-outline mr-2"></i>Need assistance?</a>
                                <button type="submit" class="py-2 px-5 rounded bg-green-500 text-white transition duration-200 hover:bg-green-600">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="md:row-start-1 md:row-end-2 bg-gradient-to-tr from-indigo-600 to-indigo-700 text-white rounded-lg shadow-lg px-8 py-5">
                        <div class="flex flex-col h-full">
                            <div class="flex-auto">
                                <h1 class="text-xl font-bold mb-2">Contact Information</h1>
                                <p class="leading-tight opacity-75">Fill up the form and our Team will get back to you within 24 hours.</p>
                                <ul class="mt-5">
                                    <li class="leading-loose"><i class="mdi mdi-phone-outline mr-2"></i>+6285655479868</li>
                                    <li class="leading-loose"><i class="mdi mdi-email-outline mr-2"></i>anggadarkprince@gmail.com</li>
                                    <li class="leading-loose"><i class="mdi mdi-map-marker-outline mr-2"></i>Avenue 34 Street, Surabaya</li>
                                </ul>
                            </div>
                            <div class="mb-2">
                                <p class="mb-2">Or visit our social media</p>
                                <a href="#" class="py-2 px-3 inline-block rounded-lg bg-blue-600 mr-2"><i class="mdi mdi-facebook"></i></a>
                                <a href="#" class="py-2 px-3 inline-block rounded-lg bg-blue-400 mr-2"><i class="mdi mdi-twitter"></i></a>
                                <a href="#" class="py-2 px-3 inline-block rounded-lg bg-indigo-500 mr-2"><i class="mdi mdi-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
