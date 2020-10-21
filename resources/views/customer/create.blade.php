@extends('layouts.app')

@section('content')
    <form action="{{ route('customers.store') }}" method="post">
        @csrf
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Create Customer</h1>
                <span class="text-gray-400">Manage all customer</span>
            </div>
            <div class="py-2">
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="customer_name" class="form-label">{{ __('Customer Name') }}</label>
                            <input id="customer_name" name="customer_name" type="text" class="form-input @error('customer_name') border-red-500 @enderror"
                                   placeholder="Customer company name" value="{{ old('customer_name') }}">
                            @error('customer_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="customer_number" class="form-label">{{ __('Customer ID Number') }}</label>
                            <input id="customer_number" name="customer_number" type="text" class="form-input @error('customer_number') border-red-500 @enderror"
                                   placeholder="Customer number" value="{{ old('customer_number') }}">
                            @error('customer_number') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="pic_name" class="form-label">{{ __('PIC Name') }}</label>
                    <input id="pic_name" name="pic_name" type="text" class="form-input @error('pic_name') border-red-500 @enderror"
                           placeholder="Person in charge" value="{{ old('pic_name') }}">
                    @error('pic_name') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="contact_phone" class="form-label">{{ __('Contact Phone') }}</label>
                            <input id="contact_phone" name="contact_phone" type="text" class="form-input @error('contact_phone') border-red-500 @enderror"
                                   placeholder="Contact phone" value="{{ old('contact_phone') }}">
                            @error('contact_phone') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="contact_email" class="form-label">{{ __('Contact Email') }}</label>
                            <input id="contact_email" name="contact_email" type="email" class="form-input @error('contact_email') border-red-500 @enderror"
                                   placeholder="Contact email" value="{{ old('contact_email') }}">
                            @error('contact_email') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap sm:mb-4">
                    <label for="contact_address" class="form-label">{{ __('Address') }}</label>
                    <textarea id="contact_address" name="contact_address" class="form-input @error('contact_address') border-red-500 @enderror"
                              placeholder="Customer address" rows="2">{{ old('contact_address') }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="flex flex-wrap">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="description" class="form-input @error('description') border-red-500 @enderror"
                              placeholder="Customer description" name="description">{{ old('description') }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-primary button-sm">Save Customer</button>
        </div>
    </form>
@endsection
