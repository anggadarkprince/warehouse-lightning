<tr class="goods-list-item" data-id="{!! $id ?? '' !!}" data-goods-id="{!! $goodsId ?? '' !!}">
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
    <td class="px-2 py-1 text-right">
        <button type="button" class="button-blue px-2 py-1 text-xs btn-take">TAKE</button>
    </td>
</tr>
