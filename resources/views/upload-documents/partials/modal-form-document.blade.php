<div id="modal-form-document" class="modal">
    <div class="modal-content">
        <div class="border-b border-gray-200 pb-3">
            <span class="close dismiss-modal">&times;</span>
            <h3 class="text-xl">Document</h3>
        </div>
        <form action="#" method="get" class="pt-3 static-form space-y-4">
            <div class="flex flex-wrap">
                <label for="document_type_id" class="form-label">{{ __('Document Type') }}</label>
                <div class="w-full">
                    <select class="form-input select-choice" name="document_type_id" id="document_type_id" required>
                        <option value="">No document type</option>
                        @foreach($documentTypes as $documentType)
                            <option value="{{ $documentType->id }}">
                                {{ $documentType->document_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-wrap">
                    <label for="document_number" class="form-label">{{ __('Document Number') }}</label>
                    <input id="document_number" name="document_number" type="text" class="form-input" autocomplete="off"
                           placeholder="Document number" required maxlength="50">
                </div>
                <div class="flex flex-wrap">
                    <label for="document_date" class="form-label">{{ __('Document Date') }}</label>
                    <div class="relative w-full">
                        <input id="document_date" name="document_date" type="text" class="form-input datepicker"
                               data-clear-button=".clear-document-date" autocomplete="off" placeholder="Document date" required maxlength="20">
                        <span class="close absolute right-0 px-3 clear-document-date" style="top: 50%; transform: translateY(-50%)">&times;</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap">
                <label for="document_description" class="form-label">{{ __('Description') }}</label>
                <textarea id="document_description" type="text" class="form-input" maxlength="500"
                          placeholder="Document description" name="document_description"></textarea>
            </div>
            <div class="border-t border-gray-200 text-right pt-4">
                <button type="button" class="button-light button-sm dismiss-modal px-5">Close</button>
                <button type="submit" class="button-primary button-sm px-5">Save</button>
            </div>
        </form>
    </div>
</div>
