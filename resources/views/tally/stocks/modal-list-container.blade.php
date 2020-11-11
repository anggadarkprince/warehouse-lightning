<div id="modal-list-container" class="modal">
    <div class="modal-content" style="max-width: 850px">
        <div class="border-b border-gray-200 pb-3">
            <span class="close dismiss-modal">&times;</span>
            <h3 class="text-xl">Container</h3>
        </div>
        <table class="table-auto w-full">
            <thead>
            <tr>
                <th class="border-b px-2 py-2 w-12">No</th>
                <th class="border-b px-2 py-2 text-left">Container</th>
                <th class="border-b px-2 py-2 text-left">Size</th>
                <th class="border-b px-2 py-2 text-left">Type</th>
                <th class="border-b px-2 py-2 text-left">Is Empty</th>
                <th class="border-b px-2 py-2 text-left">Seal</th>
                <th class="border-b px-2 py-2 text-left">Description</th>
                <th class="border-b px-2 py-2 text-left"></th>
            </tr>
            </thead>
            <tbody id="container-wrapper">
            <tr class="container-placeholder">
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

<script id="container-list-row-template" type="x-tmpl-mustache">
    @include('tally.stocks.template-list-container-row', [
        'containerOrder' => '@{{ container_order }}',
        'containerNumber' => '@{{ container_number }}',
        'containerSize' => '@{{ container_size }}',
        'containerType' => '@{{ container_type }}',
        'isEmptyLabel' => '@{{ is_empty_label }}',
        'isEmpty' => '@{{ is_empty }}',
        'seal' => '@{{ seal }}',
        'description' => '@{{ description }}',
        'containerId' => '@{{ container_id }}',
        'id' => '@{{ id }}',
    ])
</script>

<script id="container-row-template" type="x-tmpl-mustache">
    @include('tally.stocks.template-container-row', [
        'id' => '@{{ id }}',
        'containerOrder' => '@{{ container_order }}',
        'containerId' => '@{{ container_id }}',
        'containerNumber' => '@{{ container_number }}',
        'containerSize' => '@{{ container_size }}',
        'containerType' => '@{{ container_type }}',
        'isEmptyLabel' => '@{{ is_empty_label }}',
        'isEmpty' => '@{{ is_empty }}',
        'seal' => '@{{ seal }}',
        'description' => '@{{ description }}',
    ])
</script>
