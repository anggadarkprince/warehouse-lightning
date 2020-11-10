@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-2 px-6">
            <div>
                <h1 class="text-xl text-green-500">Queued Job</h1>
                <span class="text-gray-400 leading-none block">Showing outstanding work order data</span>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
            </div>
        </div>
    </div>

    @forelse($workOrders as $workOrder)
        <div class="bg-white rounded shadow-sm p-4 mb-4 flex items-center">
            <div class="flex flex-grow items-start sm:items-center">
                <div class="text-3xl mr-4">
                    @switch($workOrder->job_type)
                        @case(\App\Models\WorkOrder::TYPE_UNLOADING)
                            <i class="mdi mdi-package-variant text-green-500"></i>
                            @break
                        @case(\App\Models\WorkOrder::TYPE_LOADING)
                            <i class="mdi mdi-package-variant text-red-500"></i>
                            @break
                        @case(\App\Models\WorkOrder::TYPE_STRIPPING_CONTAINER)
                            <i class="mdi mdi-cube-send text-orange-500"></i>
                            @break
                        @case(\App\Models\WorkOrder::TYPE_RETURN_EMPTY_CONTAINER)
                            <i class="mdi mdi-truck-fast-outline text-blue-500"></i>
                            @break
                        @case(\App\Models\WorkOrder::TYPE_REPACKING_GOODS)
                        @case(\App\Models\WorkOrder::TYPE_UNPACKING_GOODS)
                            <i class="mdi mdi-package-variant-closed text-indigo-500"></i>
                            @break
                        @default
                            <i class="mdi mdi-cube-outline text-green-500"></i>
                    @endswitch
                </div>
                <div class="flex flex-grow items-start flex-col sm:flex-row sm:items-center">
                    <div class="mb-2 mr-2 sm:mb-0 sm:w-1/3">
                        <h1 class="text-lg font-bold">{{ $workOrder->job_number }}</h1>
                        <p class="text-gray-500 leading-tight">{{ $workOrder->job_type }}</p>
                    </div>
                    <div class="mb-2 mr-2 sm:mb-0 sm:w-1/3">
                        <p class="text-xs">ASSIGNED / TAKEN BY</p>
                        <p class="text-gray-500 leading-tight underline" title="Taken at {{ optional($workOrder->taken_at)->format('d M Y H:i') }}">
                            {{ optional($workOrder->user)->name ?: 'Not taken yet' }}
                        </p>
                    </div>
                    <div class="mr-2">
                        <p class="text-xs">STATUS</p>
                        <p class="text-gray-500 leading-tight">
                            {{ $workOrder->status }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="w-32 text-right ml-auto">
                @switch($workOrder->status)
                    @case(\App\Models\WorkOrder::STATUS_QUEUED)
                        <button data-href="{{ route('tally.take-job', ['work_order' => $workOrder->id]) }}"
                                data-label="{{ $workOrder->job_number }}"
                                data-action="Take Job" class="button-primary button-sm confirm-submission">
                            TAKE
                        </button>
                        @break
                    @case(\App\Models\WorkOrder::STATUS_TAKEN)
                        @if($workOrder->user_id == auth()->id())
                            <a href="{{ route('tally.proceed-job', ['work_order' => $workOrder->id]) }}" class="button-blue button-sm">
                                PROCEED <i class="mdi mdi-arrow-right"></i>
                            </a>
                        @else
                            <button class="button-light button-sm" disabled>
                                PROCEED <i class="mdi mdi-arrow-right"></i>
                            </button>
                        @endif
                        @break
                @endswitch
            </div>
        </div>
    @empty
        <div class="border-2 rounded border-dashed px-3 py-2 mb-4 text-gray-600">
            <i class="mdi mdi-file-check-outline mr-2"></i>Well done, no outstanding job available
        </div>
    @endforelse

    @include('partials.modal-confirm')
    @include('work-orders.partials.modal-filter')
@endsection
