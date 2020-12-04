<div class="py-2">
    <div class="sm:flex -mx-2">
        <div class="px-2 sm:w-1/2">
            <div class="flex flex-wrap mb-3 sm:mb-4">
                <label for="booking_name" class="form-label">{{ __('Booking Name') }}</label>
                <input id="booking_name" name="booking_name" type="text" class="form-input @error('booking_name') border-red-500 @enderror"
                       placeholder="Booking type name" value="{{ old('booking_name', optional($bookingType)->booking_name) }}">
                @error('booking_name') <p class="form-text-error">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="px-2 sm:w-1/2">
            <div class="flex flex-wrap mb-3 sm:mb-4">
                <label for="type" class="form-label">{{ __('Type') }}</label>
                <div class="w-full">
                    <select class="form-input select-choice pr-8" name="type" id="type" data-search-enable="false">
                        <option value="INBOUND"{{ old('type', optional($bookingType)->type) == 'INBOUND' ? 'selected' : '' }}>
                            {{ __('INBOUND') }}
                        </option>
                        <option value="OUTBOUND"{{ old('type', optional($bookingType)->type) == 'OUTBOUND' ? 'selected' : '' }}>
                            {{ __('OUTBOUND') }}
                        </option>
                    </select>
                </div>
                @error('type') <p class="form-text-error">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
    <div class="flex flex-wrap">
        <label for="description" class="form-label">{{ __('Description') }}</label>
        <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                  placeholder="Document type description" name="description">{{ old('description', optional($bookingType)->description) }}</textarea>
        @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
    </div>
</div>
