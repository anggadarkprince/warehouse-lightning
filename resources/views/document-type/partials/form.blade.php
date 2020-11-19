<div class="py-2 space-y-4">
    <div class="flex flex-wrap">
        <label for="document_name" class="form-label">{{ __('Document Name') }}</label>
        <input id="document_name" name="document_name" type="text" class="form-input @error('document_name') border-red-500 @enderror"
               placeholder="Document type name" value="{{ old('document_name', optional($documentType)->document_name) }}">
        @error('document_name') <p class="form-text-error">{{ $message }}</p> @enderror
    </div>
    <div class="flex flex-wrap">
        <label for="description" class="form-label">{{ __('Description') }}</label>
        <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                  placeholder="Document type description" name="description">{{ old('description', optional($documentType)->description) }}</textarea>
        @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
    </div>
</div>
