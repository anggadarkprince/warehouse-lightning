<div class="bg-white rounded shadow-sm py-4 mb-4">
    <div class="flex justify-between items-center mb-4 px-6">
        <div>
            <h1 class="text-xl text-green-500">Gate Data Scanner</h1>
            <span class="text-gray-400 leading-none block">Job management & data service</span>
        </div>
    </div>
    <div class="px-6">
        <form action="{{ route('gate.index') }}" method="get" class="static-form">
            <div class="flex flex-wrap mb-3 sm:mb-4">
                <div class="flex w-full">
                    <input type="text" name="code" id="input-code" class="form-input rounded-tr-none rounded-br-none"
                           value="<?= request()->get('code') ?>" placeholder="Input booking, delivery order or work order" aria-label="qr-code">
                    <button type="button" class="button-light relative py-2 px-4 rounded-none border border-transparent" id="btn-scanner" data-target-scanner="#input-code">
                        <i class="mdi mdi-qrcode-scan"></i>
                    </button>
                    <button type="submit" class="button-primary relative py-2 px-4 rounded-tl-none rounded-bl-none border border-transparent">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('gate.partials.modal-qr-scanner')
