@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div>
            <h1 class="text-xl text-green-500">Dashboard</h1>
            <span class="text-gray-400 block mb-3">Your main panel</span>
        </div>
        <p class="mb-4">
            A warehouse management system is a software application designed to support and optimize warehouse
            functionality and distribution center management.
            Integrates warehouse management, labour management, billing, and transportation management.
        </p>
    </div>
    <div class="sm:flex -mx-2">
        <div class="px-2 sm:w-1/3">
            <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
                <div class="flex justify-between">
                    <div>
                        <h1 class="font-bold text-red-400">Booking Total</h1>
                        <h3 class="text-2xl">{{ numeric($bookingTotal) }} <span class="text-gray-500 text-base">validated</span></h3>
                    </div>
                    <div class="chart-container" style="width: 150px">
                        <canvas id="booking-chart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-2 sm:w-1/3">
            <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
                <div class="flex justify-between">
                    <div>
                        <h1 class="font-bold text-blue-400">Delivery Total</h1>
                        <h3 class="text-2xl">{{ numeric($deliveryOrderTotal) }} <span class="text-gray-500 text-base">delivered</span></h3>
                    </div>
                    <div class="chart-container" style="width: 150px">
                        <canvas id="delivery-chart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-2 sm:w-1/3">
            <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
                <div class="flex justify-between">
                    <div>
                        <h1 class="font-bold text-green-400">Job Total</h1>
                        <h3 class="text-2xl">{{ numeric($queueJobTotal) }} of {{ numeric($jobTotal) }} <span class="text-gray-500 text-base">queued</span></h3>
                    </div>
                    <div class="chart-container" style="width: 150px">
                        <canvas id="job-chart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="md:flex -mx-2">
            <div class="px-2 md:w-1/2">
                <table class="table-auto w-full">
                    <thead>
                    <tr>
                        <th rowspan="2" class="border-b border-gray-200 p-2 text-left">
                            <p>Period</p>
                            <p class="text-gray-400 font-normal leading-tight">Weekly report</p>
                        </th>
                        <th colspan="3" class="border-b border-gray-200 p-2">Container</th>
                        <th class="border-b border-gray-200 p-2">Goods</th>
                    </tr>
                    <tr>
                        <th class="border-b border-t border-gray-200 p-2 text-blue-500">45</th>
                        <th class="border-b border-t border-gray-200 p-2 text-blue-400">40</th>
                        <th class="border-b border-t border-gray-200 p-2 text-blue-300">20</th>
                        <th class="border-b border-t border-gray-200 p-2 text-red-400">Qty</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stockContainerWeekly as $index => $container)
                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                            <td class="px-2 py-1">{{ \Carbon\Carbon::parse($container['date'])->format('d F Y') }}</td>
                            <td class="px-2 py-1 text-center text-blue-500">{{ $container['stocks']['45'] }}</td>
                            <td class="px-2 py-1 text-center text-blue-400">{{ $container['stocks']['40'] }}</td>
                            <td class="px-2 py-1 text-center text-blue-300">{{ $container['stocks']['20'] }}</td>
                            <td class="px-2 py-1 text-center text-red-400">{{ $stockGoodsWeekly->where('date', $container['date'])->first()['stocks'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-2 md:w-1/2">
                <h3 class="text-lg font-bold mb-1 text-center">Stock Containers</h3>
                <ul class="list-none text-center">
                    <li class="inline-block text-blue-500 mr-2"><i class="mdi mdi-circle-medium mr-1"></i> 45</li>
                    <li class="inline-block text-blue-400 mr-2"><i class="mdi mdi-circle-medium mr-1"></i> 40</li>
                    <li class="inline-block text-blue-300 mr-2"><i class="mdi mdi-circle-medium mr-2"></i> 20</li>
                </ul>
                <div class="chart-container mb-3">
                    <canvas id="stock-container-chart" height="100"></canvas>
                </div>
                <h3 class="text-lg font-bold mb-2 text-center text-red-400">Stock Goods</h3>
                <div class="chart-container">
                    <canvas id="stock-goods-chart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('libraries')
    <script>
        document.weeklyBooking = {!! json_encode($bookingWeekly->pluck('total')) !!}
        document.deliveryWeekly = {!! json_encode($deliveryWeekly->pluck('total')) !!}
        document.jobWeekly = {!! json_encode($jobWeekly->pluck('total')) !!}
        document.stockContainer45 = {!! json_encode($stockContainerWeekly->pluck('stocks.45')) !!}
        document.stockContainer40 = {!! json_encode($stockContainerWeekly->pluck('stocks.40')) !!}
        document.stockContainer20 = {!! json_encode($stockContainerWeekly->pluck('stocks.20')) !!}
        document.stockGoods = {!! json_encode($stockGoodsWeekly->pluck('stocks')) !!}
    </script>
@endsection
