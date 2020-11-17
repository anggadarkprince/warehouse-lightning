@extends('layouts.app')

@section('content')
    <form action="{{ route('take-stocks.store') }}" method="post" id="form-take-stock">
        @csrf
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Create Take Stock</h1>
                <span class="text-gray-400">Manage take stock data</span>
            </div>
            <div class="py-2">
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="type" class="form-label">{{ __('Type') }}</label>
                    <div class="w-full">
                        <select class="form-input select-choice" name="type" id="type" data-search-enable="false" required>
                            <option value="">Select stock type</option>
                            <option value="ALL"{{ old('type') == 'ALL' ? ' selected' : '' }}>
                                ALL STOCK
                            </option>
                            <option value="CONTAINER"{{ old('type') == 'CONTAINER' ? ' selected' : '' }}>
                                CONTAINER STOCK ONLY
                            </option>
                            <option value="GOODS"{{ old('type') == 'GOODS' ? ' selected' : '' }}>
                                GOODS STOCK ONLY
                            </option>
                        </select>
                    </div>
                    @error('type') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                              placeholder="Take stock description" name="description">{{ old('description') }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-primary button-sm">Save Take Stock</button>
        </div>
    </form>
@endsection

