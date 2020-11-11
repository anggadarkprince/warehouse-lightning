<form action="{{ route('tally.save-job', ['work_order' => $workOrder->id]) }}" method="post" id="form-tally-stripping-container">
    @csrf
    @method('put')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-3 flex justify-between items-center">
            <div>
                <h1 class="text-xl text-green-500">Containers</h1>
                <p class="text-gray-400 leading-tight">List of container data</p>
            </div>
            <button type="button" class="button-blue button-sm" id="btn-add-container" data-booking-id="{{ $bookingId ?? '' }}" data-source-url="{{ $containerSourceUrl ?? '' }}">
                ADD CONTAINER
            </button>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-2 py-2 w-12">{{ __('No') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Container Number') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Size') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Type') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Is Empty') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Seal') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Description') }}</th>
                <th class="border-b border-t px-2 py-2 text-right">{{ __('Action') }}</th>
            </tr>
            </thead>
            <tbody id="container-wrapper">
            <tr class="container-placeholder{{ empty(old('containers', $containers ?? [])) ? '' : ' hidden' }}">
                <td colspan="8" class="px-4 py-2">{{ __('No data available') }}</td>
            </tr>
            @foreach(old('containers', $containers ?? []) as $index => $container)
                @include('tally.stocks.template-container-row', [
                    'index' => $index,
                    'containerOrder' => $index + 1,
                    'id' => data_get($container, 'id', ''),
                    'containerId' => data_get($container, 'container_id'),
                    'containerNumber' => data_get($container, 'container_number', data_get($container, 'container.container_number')),
                    'containerSize' => data_get($container, 'container_size', data_get($container, 'container.container_size')),
                    'containerType' => data_get($container, 'container_type', data_get($container, 'container.container_type')),
                    'isEmptyLabel' => data_get($container, 'is_empty') ? 'Yes' : 'No',
                    'isEmpty' => data_get($container, 'is_empty'),
                    'seal' => data_get($container, 'seal') ?: '-',
                    'description' => data_get($container, 'description') ?: '-',
                ])
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 text-right">
        <button type="submit" class="button-primary button-sm">Save Job Stripping</button>
    </div>
</form>

@include('tally.stocks.modal-list-container')
@include('tally.editors.modal-form-goods', ['goods' => $masterGoods])
@include('partials.modal-info')
