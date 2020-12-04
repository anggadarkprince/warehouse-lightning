<div id="modal-info" class="modal">
    <div class="modal-content">
        <div class="border-b border-gray-200 pb-3">
            <span class="close dismiss-modal">&times;</span>
            <h3 class="text-xl modal-info-title">{{ __('Info') }}</h3>
        </div>
        <div class="pt-3">
            <p class="text-xl modal-info-message"></p>
            <p class="mb-4 text-gray-400 text-sm modal-info-sub-message"></p>
            <div class="border-t border-gray-200 text-right pt-4">
                <button type="button" class="button-light button-sm dismiss-modal px-5">{{ __('Close') }}</button>
                <button type="button" class="button-primary button-sm dismiss-modal px-5">{{ __('Ok') }}</button>
            </div>
        </div>
    </div>
</div>
