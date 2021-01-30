@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-2 px-6">
            <div>
                <h1 class="text-xl text-green-500">{{ __('Queued Job') }}</h1>
                <p class="text-gray-400 leading-tight">{{ __('Showing outstanding work order data') }}</p>
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
                        <h1 class="font-bold">{{ $workOrder->job_number }}</h1>
                        <p class="text-gray-500 leading-tight text-sm">{{ $workOrder->job_type }}</p>
                    </div>
                    <div class="mb-2 mr-2 sm:mb-0 sm:w-1/4">
                        <p class="text-xs">{{ __('ASSIGNED') }} / {{ __('TAKEN BY') }}</p>
                        <p class="text-gray-500 leading-tight underline">
                            {{ optional($workOrder->user)->name ?: 'Not taken yet' }}
                        </p>
                    </div>
                    <div class="mr-2 sm:w-1/6">
                        <p class="text-xs">{{ __('STATUS') }}</p>
                        <p class="{{ \App\Models\WorkOrder::STATUS_REJECTED == $workOrder['status'] ? 'text-red-500' : 'text-gray-500' }} leading-tight text-sm">
                            {{ $workOrder->status }}
                        </p>
                    </div>
                    <div class="mr-2 hidden md:block">
                        <p class="text-xs">{{ __('TAKEN SINCE') }}</p>
                        <p class="text-gray-500 leading-tight text-sm" title="Taken at {{ optional($workOrder->taken_at)->format('d M Y H:i') }}">
                            {{ optional($workOrder->taken_at)->diffForHumans() ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="w-40 text-right ml-auto">
                @switch($workOrder->status)
                    @case(\App\Models\WorkOrder::STATUS_QUEUED)
                        <button data-href="{{ route('tally.take-job', ['work_order' => $workOrder->id]) }}"
                                data-label="{{ $workOrder->job_number }}"
                                data-action="Take Job"
                                class="button-orange button-sm confirm-submission">
                            {{ __('TAKE') }}
                        </button>
                        @break
                    @case(\App\Models\WorkOrder::STATUS_TAKEN)
                    @case(\App\Models\WorkOrder::STATUS_REJECTED)
                        @if(Gate::allows('take', $workOrder))
                            @if(\App\Models\WorkOrder::STATUS_REJECTED == $workOrder['status'])
                                <a href="{{ route('tally.proceed-job', ['work_order' => $workOrder->id]) }}" class="button-red button-sm">
                                    {{ __('REVISE') }} <i class="mdi mdi-reload"></i>
                                </a>
                            @else
                                <a href="{{ route('tally.proceed-job', ['work_order' => $workOrder->id]) }}" class="button-blue button-sm">
                                    {{ __('PROCEED') }} <i class="mdi mdi-arrow-right"></i>
                                </a>
                            @endif
                            <button data-href="{{ route('tally.complete-job', ['work_order' => $workOrder->id]) }}"
                                    data-label="{{ $workOrder->job_number }}"
                                    data-action="Complete Job"
                                    class="button-primary button-sm confirm-submission">
                                <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                            </button>
                        @else
                            <button class="button-light button-sm" disabled>
                                {{ __('TAKEN') }}
                            </button>
                        @endif
                        @break
                    @case(\App\Models\WorkOrder::STATUS_COMPLETED)
                        <a href="{{ route('work-orders.show', ['work_order' => $workOrder->id]) }}" class="button-blue button-sm">
                            <i class="mdi mdi-eye-outline"></i>
                        </a>
                        @if(Gate::allows('validate', $workOrder))
                            <button data-href="{{ route('tally.validate-job', ['work_order' => $workOrder->id]) }}"
                                    data-label="{{ $workOrder->job_number }}"
                                    data-sub-message="Confirmed data can affect current stock"
                                    data-action="Approve"
                                    data-action-refuse="Reject"
                                    data-submit-refuse="1"
                                    data-input-message="1"
                                    class="button-primary button-sm confirm-submission">
                                {{ __('VALIDATE') }} <i class="mdi mdi-clipboard-check-outline"></i>
                            </button>
                        @else
                            <button class="button-light button-sm" disabled>
                                {{ __('COMPLETED') }}
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
