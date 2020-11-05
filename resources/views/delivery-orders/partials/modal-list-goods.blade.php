<div id="modal-list-goods" class="modal">
    <div class="modal-content" style="max-width: 1050px">
        <div class="border-b border-gray-200 pb-3">
            <span class="close dismiss-modal">&times;</span>
            <h3 class="text-xl">Goods</h3>
        </div>
        <table class="table-auto w-full">
            <thead>
            <tr>
                <th class="border-b px-2 py-2 w-12">No</th>
                <th class="border-b px-2 py-2 text-left">Goods</th>
                <th class="border-b px-2 py-2 text-left">Unit Name</th>
                <th class="border-b px-2 py-2 text-left">Unit Qty</th>
                <th class="border-b px-2 py-2 text-left" title="Package Name">Pkg Name</th>
                <th class="border-b px-2 py-2 text-left" title="Package Quantity">Pkg Qty</th>
                <th class="border-b px-2 py-2 text-left" title="Nett Weight">Weight</th>
                <th class="border-b px-2 py-2 text-left" title="Gross Weight">Gross</th>
                <th class="border-b px-2 py-2 text-left">Description</th>
                <th class="border-b px-2 py-2 text-left"></th>
            </tr>
            </thead>
            <tbody id="goods-wrapper">
            <tr class="goods-placeholder">
                <td colspan="8" class="px-4 py-2">{{ __('No data available') }}</td>
            </tr>
            </tbody>
        </table>
        <div class="border-t border-gray-200 text-right pt-4">
            <button type="button" class="button-light button-sm dismiss-modal px-5">Close</button>
            <button type="button" class="button-primary button-sm px-5 btn-reload">Reload</button>
        </div>
    </div>
</div>

<script id="goods-list-row-template" type="x-tmpl-mustache">
    @include('delivery-orders.partials.template-list-goods-row', [
        'goodsOrder' => '@{{ goods_order }}',
        'unitQuantityLabel' => '@{{ unit_quantity_label }}',
        'packageQuantityLabel' => '@{{ package_quantity_label }}',
        'weightLabel' => '@{{ weight_label }}',
        'grossWeightLabel' => '@{{ gross_weight_label }}',
        'goodsId' => '@{{ goods_id }}',
        'itemName' => '@{{ item_name }}',
        'itemNumber' => '@{{ item_number }}',
        'unitName' => '@{{ unit_name }}',
        'unitQuantity' => '@{{ unit_quantity }}',
        'packageName' => '@{{ package_name }}',
        'packageQuantity' => '@{{ package_quantity }}',
        'weight' => '@{{ weight }}',
        'gross_weight' => '@{{ gross_weight }}',
        'description' => '@{{ description }}',
        'id' => '@{{ id }}',
        'actionDeleteOnly' => $actionDeleteOnly ?? false
    ])
</script>

@include('delivery-orders.partials.modal-take-goods')
