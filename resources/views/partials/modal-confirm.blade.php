<div id="modal-confirm" class="modal">
    <div class="modal-content">
        <div class="border-b border-gray-200 pb-3">
            <span class="close dismiss-modal">&times;</span>
            <h3 class="text-xl modal-confirm-title">{{ __('Confirm') }}</h3>
        </div>
        <form action="#" method="post" class="pt-3">
            @csrf
            <p class="text-xl">
                {{ __('Are you sure want to') }} <span class="modal-confirm-message"></span> <span class="font-bold modal-confirm-label"></span>?
            </p>
            <p class="mb-4 text-gray-400 text-sm modal-confirm-sub-message"></p>
            <textarea name="message" id="confirm-message" rows="2" placeholder="Input confirmation message"
                      class="form-input mb-5 hidden" maxlength="500" aria-label="Message"></textarea>
            <div class="border-t border-gray-200 text-right pt-4">
                <button type="button" class="btn-no button-light button-sm dismiss-modal px-5">{{ __('No') }}</button>
                <button type="button" class="btn-yes button-primary button-sm dismiss-modal px-5">{{ __('Yes') }}</button>
            </div>
        </form>
    </div>
</div>
