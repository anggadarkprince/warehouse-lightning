<tr class="container-item">
    <td class="px-4 py-1 text-center container-order">{!! $containerOrder ?? '' !!}</td>
    <td class="px-4 py-1 container-number">{!! $containerNumber ?? '-' !!}</td>
    <td class="px-4 py-1 container-size">{!! $containerSize ?? '-' !!}</td>
    <td class="px-4 py-1 container-type">{!! $containerType ?? '-' !!}</td>
    <td class="px-4 py-1 container-is-empty">{!! $isEmptyLabel ?? 'No' !!}</td>
    <td class="px-4 py-1 container-seal">{!! $seal ?? '-' !!}</td>
    <td class="px-4 py-1 container-description">{!! $description ?? '-' !!}</td>
    <td class="px-4 py-1 text-right">
        <button type="button" class="button-blue px-2 py-1 text-sm btn-edit">
            <i class="mdi mdi-square-edit-outline"></i>
        </button>
        <button type="button" class="button-red px-2 py-1 text-sm btn-delete">
            <i class="mdi mdi-trash-can-outline"></i>
        </button>
        <input type="hidden" name="containers[{!! $index ?? '' !!}][id]" value="{!! $id ?? '' !!}" class="input-id">
        <input type="hidden" name="containers[{!! $index ?? '' !!}][container_id]" value="{!! $containerId !!}" class="input-container-id">
        <input type="hidden" name="containers[{!! $index ?? '' !!}][container_number]" value="{!! $containerNumber !!}" class="input-container-number">
        <input type="hidden" name="containers[{!! $index ?? '' !!}][container_type]" value="{!! $containerType !!}" class="input-container-type">
        <input type="hidden" name="containers[{!! $index ?? '' !!}][container_size]" value="{!! $containerSize !!}" class="input-container-size">
        <input type="hidden" name="containers[{!! $index ?? '' !!}][is_empty]" value="{!! $isEmpty !!}" class="input-container-is-empty">
        <input type="hidden" name="containers[{!! $index ?? '' !!}][seal]" value="{!! $seal !!}" class="input-container-seal">
        <input type="hidden" name="containers[{!! $index ?? '' !!}][description]" value="{!! $description !!}" class="input-container-description">
    </td>
</tr>
