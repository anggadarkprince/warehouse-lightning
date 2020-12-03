@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm py-4 mb-4">
        <div class="flex justify-between items-center mb-2 px-6">
            <div>
                <h1 class="text-xl text-green-500">{{ __('Notification') }}</h1>
                <p class="text-gray-400 leading-tight">Showing user notification</p>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
            </div>
        </div>
    </div>

    @forelse($notifications as $notification)
        <div class="bg-white rounded shadow-sm p-4 mb-4 flex items-center{{ $notification->unread() ? ' border border-green-500' : ' text-gray-600' }}">
            <a href="{{ route('notifications.show', ['id' => $notification->id]) }}" class="flex flex-grow items-start sm:items-center">
                <div class="text-3xl mr-4">
                    @switch($notification->type)
                        @case(\App\Notifications\WorkOrderValidated::class)
                            <i class="mdi mdi-file-check-outline text-green-500"></i>
                            @break
                        @case(\App\Notifications\WorkOrderRejected::class)
                            <i class="mdi mdi-file-alert-outline text-red-500"></i>
                            @break
                        @default
                            <i class="mdi mdi-cube-outline text-green-500"></i>
                    @endswitch
                </div>
                <div class="flex flex-grow items-start flex-col sm:flex-row sm:items-center">
                    <div class="mb-2 mr-2 sm:mb-0">
                        @switch($notification->type)
                            @case(\App\Notifications\WorkOrderValidated::class)
                                <p class="leading-tight">
                                    Job <span class="lowercase">{{ data_get($notification->data, 'job_type') }}</span> {{ data_get($notification->data, 'job_number') }} is validated
                                </p>
                                <p class="leading-tight text-sm text-gray-500">Taken by {{ data_get($notification->data, 'taken_by') }}</p>
                                @break
                            @case(\App\Notifications\WorkOrderRejected::class)
                                Job <span class="lowercase">{{ data_get($notification->data, 'job_type') }}</span> {{ data_get($notification->data, 'job_number') }} is <span class="text-red-500">REJECTED</span>
                                @break
                            @default
                                {{ data_get($notification->data, 'message') }}
                        @endswitch
                    </div>
                </div>
            </a>
            <div class="w-40 text-right ml-auto text-sm text-gray-500">
                {{ $notification->created_at->diffForHumans() }}
            </div>
        </div>
    @empty
        <div class="border-2 rounded border-dashed px-3 py-2 mb-4 text-gray-600">
            <i class="mdi mdi-file-check-outline mr-2"></i>Well done, no new notification available
        </div>
    @endforelse
@endsection
