@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="flex justify-between items-center mb-3">
            <div>
                <h1 class="text-xl text-green-500">{{ __('Stock Movement') }}</h1>
                <p class="text-gray-400 leading-tight">{{ __('Show activity stock data') }}</p>
            </div>
            <div>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
            </div>
        </div>
        <form action="{{ url()->current() }}" method="get" class="pt-1 pb-2">
            <div class="sm:flex -mx-2">
                <div class="px-2 sm:w-1/2">
                    <div class="flex flex-wrap mb-3 sm:mb-4">
                        <label for="booking_id" class="form-label">{{ __('Booking') }}</label>
                        <div class="w-full">
                            <select class="form-input select-choice" name="booking_id" id="booking_id" required>
                                <option value="">Select booking</option>
                                @foreach($bookings as $booking)
                                    <option value="{{ $booking->id }}"{{ request()->get('booking_id') == $booking->id ? ' selected' : '' }}>
                                        {{ $booking->booking_number }} - {{ $booking->reference_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="px-2 sm:w-1/2">
                    <div class="flex flex-wrap mb-3 sm:mb-4">
                        <label for="stock_date" class="form-label">{{ __('Stock Date') }}</label>
                        <div class="relative w-full">
                            <input id="delivery_date" name="stock_date" type="text" class="form-input datepicker"
                                   placeholder="Stock date" value="{{ request()->get('stock_date') }}" data-clear-button=".clear-stock-date" maxlength="20" autocomplete="off">
                            <span class="close absolute right-0 px-3 clear-stock-date" style="top: 50%; transform: translateY(-50%)">&times;</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <a href="{{ url()->current() }}" class="button-light button-sm dismiss-modal px-5">Reset</a>
                <button type="submit" class="button-primary button-sm">Apply</button>
            </div>
        </form>
    </div>

    @foreach($containers as $container)
        <div class="bg-white rounded shadow-sm py-4 mb-4">
            <div class="flex justify-between items-center mb-3 px-6">
                <h1 class="text-lg text-green-500">{{ $container->container_number }}</h1>
                <p class="text-gray-500">{{ $container->container_type }} - {{ $container->container_size }}</p>
            </div>
            <table class="table-auto w-full mb-4 whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="border-b border-t px-3 py-2 w-12">No</th>
                    <th class="border-b border-t px-3 py-2 text-left">Job Type</th>
                    <th class="border-b border-t px-3 py-2 text-left">Assigned To</th>
                    <th class="border-b border-t px-3 py-2 text-left">Completed At</th>
                    <th class="border-b border-t px-3 py-2 text-center">Balance</th>
                    <th class="border-b border-t px-3 py-2 text-center">In</th>
                    <th class="border-b border-t px-3 py-2 text-center">Out</th>
                    <th class="border-b border-t px-3 py-2 text-center">Stock</th>
                </tr>
                </thead>
                <tbody>
                <tr class="bg-red-100">
                    <td class="px-3 py-1"></td>
                    <td class="px-3 py-1 text-red-400" colspan="2">LAST BALANCE</td>
                    <td class="px-3 py-1">{{ request()->get('stock_date') }}</td>
                    <td class="px-3 py-1 text-center">{{ $container->quantity }}</td>
                    <td class="px-3 py-1 text-center"></td>
                    <td class="px-3 py-1 text-center"></td>
                    <td class="px-3 py-1 text-center bg-red-200 text-red-500">{{ $container->quantity }}</td>
                </tr>
                @foreach ($container->transactions as $index => $transaction)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-3 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-3 py-1">{{ $transaction->job_type ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $transaction->assigned_to ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $transaction->completed_at ?: '-' }}</td>
                        <td class="px-3 py-1 text-center">{{ $transaction->balance }}</td>
                        <td class="px-3 py-1 text-center">{{ $transaction->quantity > 0 ? $transaction->quantity : '' }}</td>
                        <td class="px-3 py-1 text-center">{{ $transaction->quantity < 0 ? $transaction->quantity : '' }}</td>
                        <td class="px-3 py-1 text-center{{ $index == $container->transactions->count() - 1 ? ' bg-green-200 text-green-500' : '' }}">{{ $transaction->stock }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach


    @foreach($goods as $item)
        <div class="bg-white rounded shadow-sm py-4 mb-4">
            <div class="flex justify-between items-center mb-3 px-6">
                <h1 class="text-lg text-green-500">{{ $item->item_name }}</h1>
                <p class="text-gray-500">{{ $item->container_number }}</p>
            </div>
            <table class="table-auto w-full mb-4 whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="border-b border-t px-3 py-2 w-12">No</th>
                    <th class="border-b border-t px-3 py-2 text-left">Job Type</th>
                    <th class="border-b border-t px-3 py-2 text-left">Assigned To</th>
                    <th class="border-b border-t px-3 py-2 text-left">Completed At</th>
                    <th class="border-b border-t px-3 py-2 text-center">Balance</th>
                    <th class="border-b border-t px-3 py-2 text-center">In</th>
                    <th class="border-b border-t px-3 py-2 text-center">Out</th>
                    <th class="border-b border-t px-3 py-2 text-center">Stock</th>
                </tr>
                </thead>
                <tbody>
                <tr class="bg-red-100">
                    <td class="px-3 py-1"></td>
                    <td class="px-3 py-1 text-red-400" colspan="2">LAST BALANCE</td>
                    <td class="px-3 py-1">{{ request()->get('stock_date') }}</td>
                    <td class="px-3 py-1 text-center">{{ numeric($item->quantity) }}</td>
                    <td class="px-3 py-1 text-center"></td>
                    <td class="px-3 py-1 text-center"></td>
                    <td class="px-3 py-1 text-center bg-red-200 text-red-500">{{ numeric($item->quantity) }}</td>
                </tr>
                @foreach ($item->transactions as $index => $transaction)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-3 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-3 py-1">{{ $transaction->job_type ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $transaction->assigned_to ?: '-' }}</td>
                        <td class="px-3 py-1">{{ $transaction->completed_at ?: '-' }}</td>
                        <td class="px-3 py-1 text-center">{{ numeric($transaction->balance) }}</td>
                        <td class="px-3 py-1 text-center">{{ $transaction->quantity > 0 ? numeric($transaction->quantity) : '' }}</td>
                        <td class="px-3 py-1 text-center">{{ $transaction->quantity < 0 ? numeric($transaction->quantity) : '' }}</td>
                        <td class="px-3 py-1 text-center{{ $index == $item->transactions->count() - 1 ? ' bg-green-200 text-green-500' : '' }}">{{ numeric($transaction->stock) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    @if($containers->isEmpty() && $goods->isEmpty())
        <div class="border-2 rounded border-dashed px-3 py-2 mb-4 text-gray-600">
            No data available
        </div>
    @endif

@endsection
