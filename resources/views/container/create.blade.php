@extends('layouts.app')

@section('content')
    <form action="{{ route('containers.store') }}" method="post">
        @csrf
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Create Container</h1>
                <span class="text-gray-400">Manage all container</span>
            </div>
            <div class="py-2">
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="container_number" class="form-label">{{ __('Container Number') }}</label>
                            <input id="container_number" name="container_number" type="text" class="form-input @error('container_number') border-red-500 @enderror"
                                   placeholder="Container number" value="{{ old('container_number') }}">
                            @error('container_number') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="container_size" class="form-label">{{ __('Container Size') }}</label>
                            <div class="relative w-full">
                                <select class="form-input pr-8" name="container_size" id="container_size">
                                    <option value="20"{{ old('container_size') == '20' ? 'selected' : '' }}>
                                        20
                                    </option>
                                    <option value="40"{{ old('container_size') == '40' ? 'selected' : '' }}>
                                        40
                                    </option>
                                    <option value="45"{{ old('container_size') == '45' ? 'selected' : '' }}>
                                        45
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
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="container_type" class="form-label">{{ __('Container Type') }}</label>
                            <input id="container_type" name="container_type" type="text" class="form-input @error('container_type') border-red-500 @enderror"
                                   placeholder="Container type" value="{{ old('container_type') }}">
                            @error('container_type') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="shipping_line" class="form-label">{{ __('Shipping Line') }}</label>
                            <input id="shipping_line" name="shipping_line" type="text" class="form-input @error('shipping_line') border-red-500 @enderror"
                                   placeholder="Container owner" value="{{ old('shipping_line') }}">
                            @error('shipping_line') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                              placeholder="Container description" name="description">{{ old('description') }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-primary button-sm">Save Container</button>
        </div>
    </form>
@endsection
