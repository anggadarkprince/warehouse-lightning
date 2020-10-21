@extends('layouts.app')

@section('content')
    <form action="{{ route('goods.update', ['goods' => $goods->id]) }}" method="post">
        @csrf
        @method('put')
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Edit Goods</h1>
                <span class="text-gray-400">Manage all item</span>
            </div>
            <div class="py-2">
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="item_name" class="form-label">{{ __('Item Name') }}</label>
                            <input id="item_name" name="item_name" type="text" class="form-input @error('item_name') border-red-500 @enderror"
                                   placeholder="Item name" value="{{ old('item_name', $goods->item_name) }}">
                            @error('item_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="item_number" class="form-label">{{ __('Item Number') }}</label>
                            <input id="item_number" name="item_number" type="text" class="form-input @error('item_number') border-red-500 @enderror"
                                   placeholder="Item number" value="{{ old('item_number', $goods->item_number) }}">
                            @error('item_number') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="unit_name" class="form-label">{{ __('Unit Name') }}</label>
                            <input id="unit_name" name="unit_name" type="text" class="form-input @error('unit_name') border-red-500 @enderror"
                                   placeholder="Unit name" value="{{ old('unit_name', $goods->unit_name) }}">
                            @error('unit_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="package_name" class="form-label">{{ __('Package Name') }}</label>
                            <input id="package_name" name="package_name" type="text" class="form-input @error('package_name') border-red-500 @enderror"
                                   placeholder="Unit package" value="{{ old('package_name', $goods->package_name) }}">
                            @error('package_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                              placeholder="Item description" name="description">{{ old('description', $goods->description) }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-orange button-sm">Update Goods</button>
        </div>
    </form>
@endsection
