@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-2 px-6">
            <div>
                <h1 class="text-xl text-green-500">Proceed Job <strong class="font-bold hidden sm:inline-block">{{ $workOrder->job_number }}</strong></h1>
                <span class="text-gray-400 leading-none block">Proceeding {{ strtolower($workOrder->job_type) }} job type</span>
            </div>
            <div>
                <button data-href="{{ route('tally.release-job', ['work_order' => $workOrder->id]) }}"
                        data-label="{{ $workOrder->job_number }}"
                        data-action="Release Job"  class="button-red button-sm confirm-submission">
                    Release Job
                </button>
            </div>
        </div>
    </div>

    @include('partials.modal-confirm')
@endsection
