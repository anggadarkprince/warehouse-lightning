@extends('layouts.app')

@section('content')
    <form action="{{ route('goods.store') }}" method="post">
        @csrf
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Create Goods</h1>
                <span class="text-gray-400">Manage all item</span>
            </div>
            <div class="py-2">
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="item_name" class="form-label">{{ __('Item Name') }}</label>
                            <input id="item_name" name="item_name" type="text" class="form-input @error('item_name') border-red-500 @enderror"
                                   placeholder="Item name" value="{{ old('item_name') }}">
                            @error('item_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="item_number" class="form-label">{{ __('Item Number') }}</label>
                            <input id="item_number" name="item_number" type="text" class="form-input @error('item_number') border-red-500 @enderror"
                                   placeholder="Item number" value="{{ old('item_number') }}">
                            @error('item_number') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="unit_name" class="form-label">{{ __('Unit Name') }}</label>
                            <input id="unit_name" name="unit_name" type="text" class="form-input @error('unit_name') border-red-500 @enderror"
                                   placeholder="Unit name" value="{{ old('unit_name') }}">
                            @error('unit_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="package_name" class="form-label">{{ __('Package Name') }}</label>
                            <input id="package_name" name="package_name" type="text" class="form-input @error('package_name') border-red-500 @enderror"
                                   placeholder="Unit package" value="{{ old('package_name') }}">
                            @error('package_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="unit_weight" class="form-label">{{ __('Unit Weight') }}</label>
                            <div class="flex w-full">
                                <input id="unit_weight" name="unit_weight" type="text" class="form-input input-numeric rounded-tr-none rounded-br-none @error('unit_weight') border-red-500 @enderror"
                                       placeholder="Unit weight" value="{{ old('unit_weight') }}">
                                <span class="relative button-light py-2 px-4 rounded-tl-none rounded-bl-none border border-transparent">
                                    KG
                                </span>
                            </div>
                            @error('unit_weight') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="unit_gross_weight" class="form-label">{{ __('Unit Gross Weight') }}</label>
                            <div class="flex w-full">
                                <input id="unit_gross_weight" name="unit_gross_weight" type="text" class="form-input input-numeric rounded-tr-none rounded-br-none @error('unit_gross_weight') border-red-500 @enderror"
                                       placeholder="Unit gross weight" value="{{ old('unit_gross_weight') }}">
                                <span class="relative button-light py-2 px-4 rounded-tl-none rounded-bl-none border border-transparent">
                                    KG
                                </span>
                            </div>
                            @error('unit_gross_weight') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                              placeholder="Item description" name="description">{{ old('description') }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-primary button-sm">Save Item</button>
        </div>
    </form>
@endsection
