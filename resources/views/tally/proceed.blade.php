@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="flex justify-between items-center mb-3">
            <div>
                <h1 class="text-xl text-green-500">Proceed Job</h1>
                <span class="text-gray-400 leading-tight block">Proceeding {{ strtolower($workOrder->job_type) }} job type</span>
            </div>
            <div>
                <button data-href="{{ route('tally.release-job', ['work_order' => $workOrder->id]) }}"
                        data-label="{{ $workOrder->job_number }}"
                        data-action="Release Job"  class="button-red button-sm confirm-submission">
                    Release Job
                </button>
            </div>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Job Number') }}</p>
                    <p class="text-gray-600">{{ $workOrder->job_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Job Type') }}</p>
                    <p class="text-gray-600">{{ $workOrder->job_type }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Customer') }}</p>
                    <p class="text-gray-600">{{ $workOrder->booking->customer->customer_name }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Booking Number') }}</p>
                    <p class="text-gray-600">{{ $workOrder->booking->booking_number }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Assigned To') }}</p>
                    <p class="text-gray-600">{{ optional($workOrder->user)->name ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3 flex-shrink-0">{{ __('Taken At') }}</p>
                    <p class="text-gray-600">{{ optional($workOrder->taken_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    @switch($workOrder->job_type)
        @case(\App\Models\WorkOrder::TYPE_UNLOADING)
            @include('tally.partials.job-unloading', [
                'containers' => $workOrder->workOrderContainers()->with('container')->get()->toArray(),
                'goods' => $workOrder->workOrderGoods()->with('goods')->get()->toArray(),
                'masterContainers' => $containers,
                'masterGoods' => $goods,
            ])
            @break
        @case(\App\Models\WorkOrder::TYPE_LOADING)
            @include('tally.partials.job-loading', [
                'containers' => $workOrder->workOrderContainers()->with('container')->get()->toArray(),
                'goods' => $workOrder->workOrderGoods()->with('goods')->get()->toArray(),
                'bookingId' => $workOrder->booking->id,
                'containerSourceUrl' => route('bookings.containers.index', ['booking' => $workOrder->booking_id]),
                'goodsSourceUrl' => route('bookings.goods.index', ['booking' => $workOrder->booking_id]),
            ])
            @break
        @case(\App\Models\WorkOrder::TYPE_STRIPPING_CONTAINER)
            @include('tally.partials.job-stripping-container', [
                'containers' => $workOrder->workOrderContainers()->with('container')->get()->toArray(),
                'bookingId' => $workOrder->booking->id,
                'goodsSourceUrl' => route('bookings.goods.index', ['booking' => $workOrder->booking_id]),
            ])
            @break
        @case(\App\Models\WorkOrder::TYPE_RETURN_EMPTY_CONTAINER)
            @include('tally.partials.job-return-empty-container', [
                'containers' => $workOrder->workOrderContainers()->with('container')->get()->toArray(),
                'bookingId' => $workOrder->booking->id,
                'containerSourceUrl' => route('bookings.containers.index', ['booking' => $workOrder->booking_id]),
            ])
            @break
        @case(\App\Models\WorkOrder::TYPE_REPACKING_GOODS)
        @case(\App\Models\WorkOrder::TYPE_UNPACKING_GOODS)
            @include('tally.partials.job-repacking-goods', [
                'goods' => $workOrder->workOrderGoods()->with('goods')->get()->toArray(),
                'masterGoods' => $goods,
                'bookingId' => $workOrder->booking->id,
                'goodsSourceUrl' => route('bookings.goods.index', ['booking' => $workOrder->booking_id]),
            ])
            @break
        @default <div class="border-2 rounded border-dashed px-3 py-2 mb-4 text-gray-600">Unrecognized job type of the order</div>
    @endswitch

    @include('partials.modal-confirm')
@endsection
