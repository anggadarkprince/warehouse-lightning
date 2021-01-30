@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">{{ __('Stock Containers') }}</h1>
                <p class="text-gray-400 leading-tight">{{ __('Show container stock data') }}</p>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter-container">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1, 'filter' => 'container']) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full mb-4 whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="border-b border-t border-gray-200 px-3 py-2 w-12">No</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Container Number</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Type</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Size</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Is Empty</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Seal</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Quantity</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Reference Number</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Booking Number</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Customer</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Description</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Latest Job Number</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Latest Job Type</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($stockContainers as $index => $container)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-3 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-3 py-1">
                            <a href="{{ route('reports.stock-movement', ['booking_id' => $container->booking_id]) }}" class="text-link">
                                {{ $container->container_number ?: '-' }}
                            </a>
                        </td>
                        <td class="px-3 py-1">{{ $container->container_type ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $container->container_size ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $container->is_empty ? 'Empty' : 'Loaded' }}</td>
                        <td class="px-3 py-1">{{ $container->seal ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $container->quantity ?: '0' }}</td>
                        <td class="px-3 py-1">{{ $container->reference_number }}</td>
                        <td class="px-3 py-1">{{ $container->booking_number }}</td>
                        <td class="px-3 py-1">{{ $container->customer_name ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $container->description ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $container->latest_job_number ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $container->latest_job_type ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-3 py-2" colspan="13">No data available</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6">
            {{ $stockContainers->withQueryString()->links() }}
        </div>
    </div>

    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">Stock Goods</h1>
                <p class="text-gray-400 leading-tight">Showing goods stock data</p>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter-goods">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1, 'filter' => 'goods']) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full mb-4 whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="border-b border-t border-gray-200 px-3 py-2 w-12">No</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Item Number</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Item Name</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Quantity</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Package</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Weight</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Gross</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Reference Number</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Booking Number</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Customer</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Description</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Latest Job Number</th>
                    <th class="border-b border-t border-gray-200 px-3 py-2 text-left">Latest Job Type</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($stockGoods as $index => $goods)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-3 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-3 py-1">{{ $goods->item_number ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $goods->item_name ?: '-' }}</td>
                        <td class="px-3 py-1">{{ numeric($goods->unit_quantity) }} {{ $goods->unit_name }}</td>
                        <td class="px-3 py-1">{{ numeric($goods->package_quantity) }} {{ $goods->package_name }}</td>
                        <td class="px-3 py-1">{{ numeric($goods->weight) }} Kg</td>
                        <td class="px-3 py-1">{{ numeric($goods->gross_weight) }} Kg</td>
                        <td class="px-3 py-1">{{ $goods->reference_number }}</td>
                        <td class="px-3 py-1">{{ $goods->booking_number }}</td>
                        <td class="px-3 py-1">{{ $goods->customer_name }}</td>
                        <td class="px-3 py-1">{{ $goods->description ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $goods->latest_job_number ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $goods->latest_job_type ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-3 py-2" colspan="13">No data available</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6">
            {{ $stockGoods->withQueryString()->links() }}
        </div>
    </div>

    @include('report-stocks.partials.modal-filter-container')
    @include('report-stocks.partials.modal-filter-goods')
@endsection
