<form action="{{ route('tally.save-job', ['work_order' => $workOrder->id]) }}" method="post" id="form-tally-unpacking">
    @csrf
    @method('put')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-3 flex justify-between items-center">
            <div>
                <h1 class="text-xl text-green-500">Goods</h1>
                <p class="text-gray-400 leading-tight">List of goods data</p>
            </div>
            <button type="button" class="button-blue button-sm" id="btn-add-goods" data-booking-id="{{ $bookingId ?? '' }}" data-source-url="{{ $goodsSourceUrl ?? '' }}">
                ADD GOODS
            </button>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-2 py-2 w-12">{{ __('No') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Item Name') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Quantity') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Package') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Weight') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Gross') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Description') }}</th>
                <th class="border-b border-t px-2 py-2 text-right">{{ __('Action') }}</th>
            </tr>
            </thead>
            <tbody id="goods-wrapper">
            <tr class="goods-placeholder{{ empty(old('goods', $goods ?? [])) ? '' : ' hidden' }}">
                <td colspan="9" class="px-4 py-2">{{ __('No data available') }}</td>
            </tr>
            @foreach(old('goods', $goods ?? []) as $index => $item)
                @include('tally.stocks.template-goods-row', [
                    'index' => $index,
                    'goodsOrder' => $index + 1,
                    'id' => data_get($item, 'id', ''),
                    'referenceId' => data_get($item, 'reference_id', data_get($item, 'booking_id', data_get($item, 'id'))),
                    'unitQuantityLabel' => numeric(data_get($item, 'unit_quantity')),
                    'packageQuantityLabel' => numeric(data_get($item, 'package_quantity')),
                    'weightLabel' => numeric(data_get($item, 'weight')),
                    'grossWeightLabel' => numeric(data_get($item, 'gross_weight')),
                    'goodsId' => data_get($item, 'goods_id'),
                    'itemName' => data_get($item, 'item_name', data_get($item, 'goods.item_name')),
                    'itemNumber' => data_get($item, 'item_number', data_get($item, 'goods.item_number')),
                    'unitName' => data_get($item, 'unit_name', data_get($item, 'goods.unit_name')),
                    'unitQuantity' => data_get($item, 'unit_quantity'),
                    'packageName' => data_get($item, 'package_name', data_get($item, 'goods.package_name')),
                    'packageQuantity' => data_get($item, 'package_quantity'),
                    'weight' => data_get($item, 'weight'),
                    'grossWeight' => data_get($item, 'gross_weight'),
                    'description' => data_get($item, 'description') ?: '-',
                    'actionDeleteOnly' => true
                ])
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 text-right">
        <button type="submit" class="button-primary button-sm">Save Job Unpacking</button>
    </div>
</form>

@include('tally.stocks.modal-list-goods', ['actionDeleteOnly' => true])
@include('tally.editors.modal-form-goods', ['goods' => $masterGoods])
@include('partials.modal-info')
