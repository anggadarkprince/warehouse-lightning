@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-3">
            <h1 class="text-xl text-green-500">{{ __('Take Stock') }}</h1>
            <p class="text-gray-400 leading-tight">{{ __('Manage take stock data') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Take Stock Number') }}</p>
                    <p class="text-gray-600">{{ $takeStock->take_stock_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Status') }}</p>
                    <p class="text-gray-600">{{ $takeStock->status }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Description') }}</p>
                    <p class="text-gray-600">{{ $takeStock->description ?: '-' }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Created At') }}</p>
                    <p class="text-gray-600">{{ optional($takeStock->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Updated At') }}</p>
                    <p class="text-gray-600">{{ optional($takeStock->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($takeStock->takeStockContainers()->exists())
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-3 flex items-center justify-between">
                <div>
                    <h1 class="text-xl text-green-500">{{ __('Containers') }}</h1>
                    <p class="text-gray-400 leading-tight">{{ __('List of booking containers') }}</p>
                </div>
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
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Rev Qty') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Rev Desc') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($takeStock->takeStockContainers as $index => $takeStockContainer)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-2 py-1">
                            <a href="{{ route('containers.show', ['container' => $takeStockContainer->container->id]) }}" class="text-link">
                                {{ $takeStockContainer->container->container_number }}
                            </a>
                        </td>
                        <td class="px-2 py-1">{{ $takeStockContainer->container->container_size }}</td>
                        <td class="px-2 py-1">{{ $takeStockContainer->container->container_type }}</td>
                        <td class="px-2 py-1">{{ $takeStockContainer->is_empty ? 'Yes' : 'No' }}</td>
                        <td class="px-2 py-1">{{ $takeStockContainer->seal ?: '-' }}</td>
                        <td class="px-2 py-1 bg-red-100">{{ numeric($takeStockContainer->revision_quantity) ?: 0 }}</td>
                        <td class="px-2 py-1 bg-red-100">{{ $takeStockContainer->revision_description ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-2 py-2">{{ __('No data available') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif

    @if($takeStock->takeStockGoods()->exists())
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-3 flex items-center justify-between">
                <div>
                    <h1 class="text-xl text-green-500">{{ __('Goods') }}</h1>
                    <p class="text-gray-400 leading-tight">{{ __('List of booking goods') }}</p>
                </div>
            </div>
            <table class="table-auto w-full mb-4">
                <thead>
                <tr class="whitespace-no-wrap">
                    <th class="border-b border-t px-2 py-2 w-12">{{ __('No') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Item Name') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Quantity') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Package') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Weight') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Gross') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Rev Qty') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Rev Pkg') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Rev Weight') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Rev Gross') }}</th>
                    <th class="border-b border-t px-2 py-2 text-left">{{ __('Rev Desc') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($takeStock->takeStockGoods as $index => $takeStockItem)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-2 py-1" style="min-width: 200px">
                            <a href="{{ route('goods.show', ['goods' => $takeStockItem->goods->id]) }}" class="text-link block leading-tight">
                                {{ $takeStockItem->goods->item_name }}
                            </a>
                            <p class="text-xs text-gray-500 leading-tight">{{ $takeStockItem->goods->item_number }}</p>
                        </td>
                        <td class="px-2 py-1">{{ numeric($takeStockItem->unit_quantity) }}</td>
                        <td class="px-2 py-1">{{ numeric($takeStockItem->package_quantity) }}</td>
                        <td class="px-2 py-1">{{ numeric($takeStockItem->weight) }}</td>
                        <td class="px-2 py-1">{{ numeric($takeStockItem->gross_weight) }}</td>
                        <td class="px-2 py-1 bg-red-100">{{ numeric($takeStockItem->revision_unit_quantity) }}</td>
                        <td class="px-2 py-1 bg-red-100">{{ numeric($takeStockItem->revision_package_quantity) }}</td>
                        <td class="px-2 py-1 bg-red-100">{{ numeric($takeStockItem->revision_weight) }}</td>
                        <td class="px-2 py-1 bg-red-100">{{ numeric($takeStockItem->revision_gross_weight) }}</td>
                        <td class="px-2 py-1 bg-red-100">{{ $takeStockItem->revision_description ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-2 py-2">{{ __('No data available') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-3 flex items-center justify-between">
            <div>
                <h1 class="text-xl text-green-500">{{ __('Status Histories') }}</h1>
                <p class="text-gray-400 leading-tight">{{ __('List of booking statuses') }}</p>
            </div>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-2 py-2 w-12">{{ __('No') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Status') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Description') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Data') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Created At') }}</th>
                <th class="border-b border-t px-2 py-2 text-left">{{ __('Created By') }}</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $takeStockStatuses = [
                \App\Models\TakeStock::STATUS_PENDING => 'bg-gray-200',
                \App\Models\TakeStock::STATUS_IN_PROCESS => 'bg-orange-500',
                \App\Models\TakeStock::STATUS_SUBMITTED => 'bg-blue-500',
                \App\Models\TakeStock::STATUS_REJECTED => 'bg-red-500',
                \App\Models\TakeStock::STATUS_VALIDATED => 'bg-green-500',
            ];
            ?>
            @forelse ($takeStock->statusHistories as $index => $statusHistory)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-2 py-1">
                        <span class="px-2 py-1 rounded text-xs {{ $statusHistory->status == 'PENDING' ? '' : 'text-white' }} {{ data_get($takeStockStatuses, $statusHistory->status, 'bg-gray-200') }}">
                            {{ $statusHistory->status }}
                        </span>
                    </td>
                    <td class="px-2 py-1">{{ $statusHistory->description ?: '-' }}</td>
                    <td class="px-2 py-1">{{ $statusHistory->data ?: '-' }}</td>
                    <td class="px-2 py-1">{{ optional($statusHistory->created_at)->format('d F Y H:i:s') ?: '-' }}</td>
                    <td class="px-2 py-1">{{ optional($statusHistory->creator)->name ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-2 py-2">{{ __('No data available') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">{{ __('back') }}</button>
    </div>
@endsection
