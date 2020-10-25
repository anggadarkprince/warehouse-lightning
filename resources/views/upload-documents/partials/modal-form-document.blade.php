<div id="modal-form-document" class="modal">
    <div class="modal-content">
        <div class="border-b border-gray-200 pb-3">
            <span class="close dismiss-modal">&times;</span>
            <h3 class="text-xl">Document</h3>
        </div>
        <form action="#" method="get" class="pt-3 static-form space-y-4">
            <div class="flex flex-wrap">
                <label for="document_type_id" class="form-label">{{ __('Document Type') }}</label>
                <div class="relative w-full">
                    <select class="form-input pr-8" name="document_type_id" id="document_type_id" required>
                        <option value="">-- Select Document --</option>
                        @foreach($documentTypes as $documentType)
                            <option value="{{ $documentType->id }}">
                                {{ $documentType->document_name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-wrap">
                    <label for="document_number" class="form-label">{{ __('Document Number') }}</label>
                    <input id="document_number" name="document_number" type="text" class="form-input" autocomplete="off"
                           placeholder="Document number" required>
                </div>
                <div class="flex flex-wrap">
                    <label for="document_date" class="form-label">{{ __('Document Date') }}</label>
                    <div class="relative w-full">
                        <input id="document_date" name="document_date" type="text" class="form-input datepicker"
                               data-clear-button=".clear-document-date" autocomplete="off" placeholder="Document date" required>
                        <span class="close absolute right-0 px-3 clear-document-date" style="top: 50%; transform: translateY(-50%)">&times;</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap">
                <label for="document_description" class="form-label">{{ __('Description') }}</label>
                <textarea id="document_description" type="text" class="form-input"
                          placeholder="Document description" name="document_description"></textarea>
            </div>
            <div class="border-t border-gray-200 text-right pt-4">
                <button type="button" class="button-light button-sm dismiss-modal px-5">Close</button>
                <button type="submit" class="button-primary button-sm px-5">Save</button>
            </div>
        </form>
    </div>
</div>
