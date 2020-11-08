<div id="modal-take-goods" class="modal">
    <div class="modal-content" style="max-width: 600px">
        <div class="border-b border-gray-200 pb-3">
            <span class="close dismiss-modal">&times;</span>
            <h3 class="text-xl">Take Goods</h3>
        </div>
        <form action="#" method="get" class="pt-3 static-form space-y-4">
            <div class="flex flex-wrap">
                <label for="goods_item_name" class="form-label">{{ __('Item Name') }}</label>
                <input id="goods_item_name" name="goods_item_name" type="text" class="form-input" autocomplete="off"
                       placeholder="Item name" readonly>
            </div>
            <div class="md:flex -mx-2">
                <div class="px-2 md:w-1/2">
                    <div class="flex flex-wrap">
                        <label for="goods_take_unit_quantity" class="form-label">
                            {{ __('Unit Quantity') }}
                            (<span id="goods_label_unit_name">UNIT</span>)
                        </label>
                        <div class="flex w-full">
                            <input id="goods_unit_quantity" name="goods_unit_quantity" type="text" class="form-input input-numeric rounded-tr-none rounded-br-none" autocomplete="off"
                                   placeholder="Unit quantity" aria-label="Unit quantity" readonly>
                            <input id="goods_take_unit_quantity" name="goods_take_unit_quantity" type="text" class="form-input input-numeric rounded-tl-none rounded-bl-none border-green-500 bg-white"
                                   autocomplete="off" placeholder="Take" required>
                        </div>
                    </div>
                </div>
                <div class="px-2 md:w-1/2">
                    <div class="flex flex-wrap">
                        <label for="goods_take_package_quantity" class="form-label">
                            {{ __('Package Quantity') }}
                            (<span id="goods_label_unit_package">UNIT</span>)
                        </label>
                        <div class="flex w-full">
                            <input id="goods_package_quantity" name="goods_package_quantity" type="text" class="form-input input-numeric rounded-tr-none rounded-br-none" autocomplete="off"
                                   placeholder="Package quantity" aria-label="Package quantity" readonly>
                            <input id="goods_take_package_quantity" name="goods_take_package_quantity" type="text" class="form-input input-numeric rounded-tl-none rounded-bl-none border-green-500 bg-white"
                                   autocomplete="off" placeholder="Take" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:flex -mx-2">
                <div class="px-2 md:w-1/2">
                    <label for="goods_take_weight" class="form-label">{{ __('Weight') }} (Kg)</label>
                    <div class="flex w-full">
                        <input id="goods_weight" name="goods_weight" type="text" class="form-input input-numeric rounded-tr-none rounded-br-none"
                               autocomplete="off" placeholder="Total weight" aria-label="Weight" readonly>
                        <input id="goods_take_weight" name="goods_take_weight" type="text" class="form-input input-numeric rounded-tl-none rounded-bl-none border-green-500 bg-white"
                               autocomplete="off" placeholder="Take" required>
                    </div>
                </div>
                <div class="px-2 md:w-1/2">
                    <label for="goods_take_gross_weight" class="form-label">{{ __('Gross Weight') }} (Kg)</label>
                    <div class="flex w-full">
                        <input id="goods_gross_weight" name="goods_gross_weight" type="text" class="form-input input-numeric rounded-tr-none rounded-br-none"
                               autocomplete="off" placeholder="Total gross weight" aria-label="Gross" readonly>
                        <input id="goods_take_gross_weight" name="goods_take_gross_weight" type="text" class="form-input input-numeric rounded-tl-none rounded-bl-none border-green-500 bg-white"
                               autocomplete="off" placeholder="Take" required>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 text-right pt-4">
                <button type="button" class="button-light button-sm dismiss-modal px-5">Close</button>
                <button type="button" class="button-light button-sm px-5" id="btn-take-all">Take All</button>
                <button type="submit" class="button-primary button-sm px-5">Take</button>
            </div>
        </form>
    </div>
</div>

<script id="goods-row-template" type="x-tmpl-mustache">
    @include('delivery-orders.partials.template-goods-row', [
        'id' => '@{{ id }}',
        'goodsOrder' => '@{{ goods_order }}',
        'referenceId' => '@{{ reference_id }}',
        'unitQuantityLabel' => '@{{ unit_quantity_label }}',
        'packageQuantityLabel' => '@{{ package_quantity_label }}',
        'weightLabel' => '@{{ weight_label }}',
        'grossWeightLabel' => '@{{ gross_weight_label }}',
        'goodsId' => '@{{ goods_id }}',
        'itemName' => '@{{ item_name }}',
        'itemNumber' => '@{{ item_number }}',
        'unitName' => '@{{ unit_name }}',
        'unitQuantity' => '@{{ unit_quantity }}',
        'unitQuantityDefault' => '@{{ unit_quantity_default }}',
        'packageName' => '@{{ package_name }}',
        'packageQuantity' => '@{{ package_quantity }}',
        'packageQuantityDefault' => '@{{ package_quantity_default }}',
        'weight' => '@{{ weight }}',
        'weightDefault' => '@{{ weight_default }}',
        'grossWeight' => '@{{ gross_weight }}',
        'grossWeightDefault' => '@{{ gross_weight_default }}',
        'description' => '@{{ description }}',
    ])
</script>
