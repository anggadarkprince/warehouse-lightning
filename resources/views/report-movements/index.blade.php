@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="flex justify-between items-center mb-3">
            <div>
                <h1 class="text-xl text-green-500">Stock Movement</h1>
                <p class="text-gray-400 leading-tight">Show activity stock data</p>
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
                        <div class="relative w-full">
                            <select class="form-input pr-8" name="booking_id" id="booking_id" required>
                                <option value="">-- Select booking --</option>
                                @foreach($bookings as $booking)
                                    <option value="{{ $booking->id }}"{{ request()->get('booking_id') == $booking->id ? ' selected' : '' }}>
                                        {{ $booking->booking_number }} - {{ $booking->reference_number }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
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
                <p class="text-gray-400">{{ $container->container_type }} - {{ $container->container_size }}</p>
            </div>
            <div class="overflow-x-scroll">
                <table class="table-auto w-full mb-4 whitespace-no-wrap">
                    <thead>
                    <tr>
                        <th class="border-b border-t px-3 py-2 w-12">No</th>
                        <th class="border-b border-t px-3 py-2 text-left">Job Type</th>
                        <th class="border-b border-t px-3 py-2 text-left">Assigned To</th>
                        <th class="border-b border-t px-3 py-2 text-left">Completed At</th>
                        <th class="border-b border-t px-3 py-2 text-left">Balance</th>
                        <th class="border-b border-t px-3 py-2 text-left">In</th>
                        <th class="border-b border-t px-3 py-2 text-left">Out</th>
                        <th class="border-b border-t px-3 py-2 text-left">Stock</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="px-3 py-1"></td>
                        <td class="px-3 py-1" colspan="3">LAST BALANCE</td>
                        <td class="px-3 py-1">{{ $container->quantity }}</td>
                        <td class="px-3 py-1"></td>
                        <td class="px-3 py-1"></td>
                        <td class="px-3 py-1">{{ $container->quantity }}</td>
                    </tr>
                    @foreach ($container->transactions as $index => $transaction)
                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                            <td class="px-3 py-1 text-center">{{ $index + 1 }}</td>
                            <td class="px-3 py-1">{{ $transaction->job_type ?: '-' }}</td>
                            <td class="px-3 py-1">{{ $transaction->assigned_to ?: '-' }}</td>
                            <td class="px-3 py-1">{{ $transaction->completed_at ?: '-' }}</td>
                            <td class="px-3 py-1">{{ $transaction->balance }}</td>
                            <td class="px-3 py-1">{{ $transaction->quantity > 0 ? $transaction->quantity : '' }}</td>
                            <td class="px-3 py-1">{{ $transaction->quantity < 0 ? $transaction->quantity : '' }}</td>
                            <td class="px-3 py-1">{{ $transaction->stock }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach


    @foreach($goods as $item)
        <div class="bg-white rounded shadow-sm py-4 mb-4">
            <div class="flex justify-between items-center mb-3 px-6">
                <h1 class="text-lg text-green-500">{{ $item->item_name }}</h1>
                <p class="text-gray-400">{{ $item->container_number }}</p>
            </div>
            <div class="overflow-x-scroll">
                <table class="table-auto w-full mb-4 whitespace-no-wrap">
                    <thead>
                    <tr>
                        <th class="border-b border-t px-3 py-2 w-12">No</th>
                        <th class="border-b border-t px-3 py-2 text-left">Job Type</th>
                        <th class="border-b border-t px-3 py-2 text-left">Assigned To</th>
                        <th class="border-b border-t px-3 py-2 text-left">Completed At</th>
                        <th class="border-b border-t px-3 py-2 text-left">Balance</th>
                        <th class="border-b border-t px-3 py-2 text-left">In</th>
                        <th class="border-b border-t px-3 py-2 text-left">Out</th>
                        <th class="border-b border-t px-3 py-2 text-left">Stock</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="px-3 py-1"></td>
                        <td class="px-3 py-1" colspan="3">LAST BALANCE</td>
                        <td class="px-3 py-1">{{ numeric($item->quantity) }}</td>
                        <td class="px-3 py-1"></td>
                        <td class="px-3 py-1"></td>
                        <td class="px-3 py-1">{{ numeric($item->quantity) }}</td>
                    </tr>
                    @foreach ($item->transactions as $index => $transaction)
                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                            <td class="px-3 py-1 text-center">{{ $index + 1 }}</td>
                            <td class="px-3 py-1">{{ $transaction->job_type ?: '-' }}</td>
                            <td class="px-3 py-1">{{ $transaction->assigned_to ?: '-' }}</td>
                            <td class="px-3 py-1">{{ $transaction->completed_at ?: '-' }}</td>
                            <td class="px-3 py-1">{{ numeric($transaction->balance) }}</td>
                            <td class="px-3 py-1">{{ $transaction->quantity > 0 ? numeric($transaction->quantity) : '' }}</td>
                            <td class="px-3 py-1">{{ $transaction->quantity < 0 ? numeric($transaction->quantity) : '' }}</td>
                            <td class="px-3 py-1">{{ numeric($transaction->stock) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    @if($containers->isEmpty() && $goods->isEmpty())
        <div class="border-2 rounded border-dashed px-3 py-2 mb-4 text-gray-600">
            No data available
        </div>
    @endif

@endsection
