<tr class="goods-item">
    <td class="px-2 py-1 text-center goods-order">{!! $goodsOrder ?? '' !!}</td>
    <td class="px-2 py-1">
        <p class="leading-tight goods-item-name">{!! $itemName ?? '-' !!}</p>
        <p class="leading-none text-gray-500 text-xs goods-item-number">{!! $itemNumber ?? '' !!}</p>
    </td>
    <td class="px-2 py-1 goods-unit-name">{!! $unitName ?? '-' !!}</td>
    <td class="px-2 py-1 goods-unit-quantity">{!! $unitQuantityLabel ?? '0' !!}</td>
    <td class="px-2 py-1 goods-package-name">{!! $packageName ?? '-' !!}</td>
    <td class="px-2 py-1 goods-package-quantity">{!! $packageQuantityLabel ?? '0' !!}</td>
    <td class="px-2 py-1 goods-weight">{!! $weightLabel ?? '0' !!}</td>
    <td class="px-2 py-1 goods-gross-weight">{!! $grossWeightLabel ?? '0' !!}</td>
    <td class="px-2 py-1 goods-description">{!! $description ?? '-' !!}</td>
    <td class="px-2 py-1 text-right whitespace-no-wrap">
        <button type="button" class="button-blue px-2 py-1 text-sm btn-edit">
            <i class="mdi mdi-square-edit-outline"></i>
        </button>
        <button type="button" class="button-red px-2 py-1 text-sm btn-delete">
            <i class="mdi mdi-trash-can-outline"></i>
        </button>
        <input type="hidden" name="goods[{!! $index ?? '' !!}][id]" value="{!! $id ?? '' !!}" class="input-id">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][goods_id]" value="{!! $goodsId !!}" class="input-goods-id">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][item_name]" value="{!! $itemName !!}" class="input-goods-item-name">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][item_number]" value="{!! $itemNumber !!}" class="input-goods-item-number">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][unit_name]" value="{!! $unitName !!}" class="input-goods-unit-name">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][unit_quantity]" value="{!! $unitQuantity !!}" class="input-goods-unit-quantity">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][package_name]" value="{!! $packageName !!}" class="input-goods-package-name">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][package_quantity]" value="{!! $packageQuantity !!}" class="input-goods-package-quantity">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][weight]" value="{!! $weight !!}" class="input-goods-weight">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][gross_weight]" value="{!! $grossWeight !!}" class="input-goods-gross-weight">
        <input type="hidden" name="goods[{!! $index ?? '' !!}][description]" value="{!! $description !!}" class="input-goods-description">
    </td>
</tr>
