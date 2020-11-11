<tr class="goods-item">
    <td class="px-2 py-1 text-center goods-order">{!! $goodsOrder ?? '' !!}</td>
    <td class="px-2 py-1">
        <p class="leading-tight goods-item-name">{!! $itemName ?? '-' !!}</p>
        <p class="leading-none text-gray-500 text-xs goods-item-number">{!! $itemNumber ?? '' !!}</p>
    </td>
    <td class="px-2 py-1">
        <span class="goods-unit-quantity">{!! $unitQuantityLabel ?? '0' !!}</span>
        <span class="goods-unit-name uppercase">{!! $unitName ?? '-' !!}</span>
    </td>
    <td class="px-2 py-1">
        <span class="goods-package-quantity">{!! $packageQuantityLabel ?? '0' !!}</span>
        <span class="goods-package-name uppercase">{!! $packageName ?? '-' !!}</span>
    </td>
    <td class="px-2 py-1">
        <span class="goods-weight">{!! $weightLabel ?? '0' !!}</span>
        <span class="uppercase">Kg</span>
    </td>
    <td class="px-2 py-1">
        <span class="goods-gross-weight">{!! $grossWeightLabel ?? '0' !!}</span>
        <span class="uppercase">Kg</span>
    </td>
    <td class="px-2 py-1 goods-description">{!! $description ?? '-' !!}</td>
    <td class="px-2 py-1 text-right whitespace-no-wrap">
        @if(!($actionDeleteOnly ?? false))
            <button type="button" class="button-blue px-2 py-1 text-sm btn-edit">
                <i class="mdi mdi-square-edit-outline"></i>
            </button>
        @endif
        <button type="button" class="button-red px-2 py-1 text-sm btn-delete">
            <i class="mdi mdi-trash-can-outline"></i>
        </button>
        <input type="hidden" name="goods[{!! $index ?? '' !!}][id]" value="{!! $id ?? '' !!}" class="input-id">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][reference_id]" value="{!! $referenceId ?? '' !!}" class="input-reference-id">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][goods_id]" value="{!! $goodsId !!}" class="input-goods-id">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][item_name]" value="{!! $itemName !!}" class="input-goods-item-name">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][item_number]" value="{!! $itemNumber !!}" class="input-goods-item-number">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][unit_name]" value="{!! $unitName !!}" class="input-goods-unit-name">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][unit_quantity]" value="{!! $unitQuantity !!}" data-default="{!! $unitQuantityDefault ?? '' !!}" class="input-goods-unit-quantity">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][package_name]" value="{!! $packageName !!}" class="input-goods-package-name">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][package_quantity]" value="{!! $packageQuantity !!}" data-default="{!! $packageQuantityDefault ?? '' !!}" class="input-goods-package-quantity">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][weight]" value="{!! $weight !!}" data-default="{!! $weightDefault ?? '' !!}" class="input-goods-weight">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][gross_weight]" value="{!! $grossWeight !!}" data-default="{!! $grossWeightDefault ?? '' !!}" class="input-goods-gross-weight">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][description]" value="{!! $description !!}" class="input-goods-description">
    </td>
</tr>
