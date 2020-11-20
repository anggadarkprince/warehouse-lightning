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
@endsection
@section('libraries')
    <script>
        document.weeklyBooking = {!! json_encode($bookingWeekly->pluck('total')) !!}
        document.deliveryWeekly = {!! json_encode($deliveryWeekly->pluck('total')) !!}
        document.jobWeekly = {!! json_encode($jobWeekly->pluck('total')) !!}
    </script>
@endsection
