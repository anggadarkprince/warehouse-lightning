<tr class="container-list-item" data-id="{!! $id ?? '' !!}" data-container-id="{!! $containerId ?? '' !!}">
    <td class="px-2 py-1 text-center container-order">{!! $containerOrder ?? '' !!}</td>
    <td class="px-2 py-1 container-number">{!! $containerNumber ?? '-' !!}</td>
    <td class="px-2 py-1 container-size">{!! $containerSize ?? '-' !!}</td>
    <td class="px-2 py-1 container-type">{!! $containerType ?? '-' !!}</td>
    <td class="px-2 py-1 container-is-empty">{!! $isEmptyLabel ?? 'No' !!}</td>
    <td class="px-2 py-1 container-seal">{!! $seal ?? '-' !!}</td>
    <td class="px-2 py-1 container-description">{!! $description ?? '-' !!}</td>
    <td class="px-2 py-1 text-right">
        <button type="button" class="button-blue px-2 py-1 text-xs btn-take">TAKE</button>
    </td>
</tr>
