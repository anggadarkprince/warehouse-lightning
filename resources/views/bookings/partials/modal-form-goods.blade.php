<div id="modal-form-goods" class="modal">
    <div class="modal-content">
        <div class="border-b border-gray-200 pb-3">
            <span class="close dismiss-modal">&times;</span>
            <h3 class="text-xl">Goods</h3>
        </div>
        <form action="#" method="get" class="pt-3 static-form space-y-4">
            <div class="flex flex-wrap">
                <label for="goods_id" class="form-label">{{ __('Item') }}</label>
                <div class="relative w-full">
                    <select class="form-input pr-8" name="goods_id" id="goods_id" required>
                        <option value="">-- Select Goods --</option>
                        @foreach($goods as $item)
                            <option value="{{ $item->id }}"
                                    data-item-name="{{ $item->item_name }}"
                                    data-item-number="{{ $item->item_number }}"
                                    data-package-name="{{ $item->package_name }}"
                                    data-unit-name="{{ $item->unit_name }}">
                                {{ $item->item_name }} - {{ $item->unit_name }}, {{ $item->package_name }}
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
                    <label for="goods_unit_quantity" class="form-label">{{ __('Unit Quantity') }}</label>
                    <input id="goods_unit_quantity" name="goods_unit_quantity" type="text" class="form-input input-numeric" autocomplete="off"
                           placeholder="Unit quantity">
                </div>
                <div class="flex flex-wrap">
                    <label for="goods_package_quantity" class="form-label">{{ __('Package Quantity') }}</label>
                    <input id="goods_package_quantity" name="goods_package_quantity" type="text" class="form-input input-numeric" autocomplete="off"
                           placeholder="Package quantity">
                </div>
            </div>
            <div class="flex flex-wrap">
                <label for="goods_weight" class="form-label">{{ __('Weight') }}</label>
                <input id="goods_weight" name="goods_weight" type="text" class="form-input input-numeric" autocomplete="off"
                       placeholder="Total weight">
            </div>
            <div class="flex flex-wrap">
                <label for="goods_description" class="form-label">{{ __('Description') }}</label>
                <textarea id="goods_description" type="text" class="form-input"
                          placeholder="Goods description" name="goods_description"></textarea>
            </div>
            <div class="border-t border-gray-200 text-right pt-4">
                <button type="button" class="button-light button-sm dismiss-modal px-5">Close</button>
                <button type="submit" class="button-primary button-sm px-5">Save</button>
            </div>
        </form>
    </div>
</div>

<script id="goods-row-template" type="x-tmpl-mustache">
    @include('bookings.partials.template-goods-row', [
        'unitQuantityLabel' => '@{{ unit_quantity_label }}',
        'packageQuantityLabel' => '@{{ package_quantity_label }}',
        'weightLabel' => '@{{ weight_label }}',
        'goodsId' => '@{{ goods_id }}',
        'itemName' => '@{{ item_name }}',
        'itemNumber' => '@{{ item_number }}',
        'unitName' => '@{{ unit_name }}',
        'unitQuantity' => '@{{ unit_quantity }}',
        'packageName' => '@{{ package_name }}',
        'packageQuantity' => '@{{ package_quantity }}',
        'weight' => '@{{ weight }}',
        'description' => '@{{ description }}',
    ])
</script>
