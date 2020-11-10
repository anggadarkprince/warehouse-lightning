@extends('layouts.app')

@section('content')
    <form action="{{ route('work-orders.store') }}" method="post" id="form-work-order">
        @csrf
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Create Work Order</h1>
                <span class="text-gray-400">Manage job data</span>
            </div>
            <div class="flex flex-wrap mb-3 sm:mb-4">
                <label for="booking_id" class="form-label">{{ __('Booking') }}</label>
                <div class="relative w-full">
                    <select class="form-input pr-8" name="booking_id" id="booking_id" required>
                        <option value="">-- Select booking --</option>
                        @foreach($bookings as $booking)
                            <option value="{{ $booking->id }}" data-type="{{ $booking->bookingType->type }}"{{ old('booking_id') == $booking->id ? ' selected' : '' }}>
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
                @error('booking_id') <p class="form-text-error">{{ $message }}</p> @enderror
            </div>
            <div class="sm:flex -mx-2">
                <div class="px-2 sm:w-1/2">
                    <div class="flex flex-wrap mb-3 sm:mb-4">
                        <label for="job_type" class="form-label">{{ __('Job Type') }}</label>
                        <div class="relative w-full">
                            <select class="form-input pr-8" name="job_type" id="job_type" required>
                                <option value="">-- Select type --</option>
                                <option value="{{ \App\Models\WorkOrder::TYPE_UNLOADING }}"{{ old('job_type') == \App\Models\WorkOrder::TYPE_UNLOADING ? ' selected' : '' }}>
                                    {{ Str::of(\App\Models\WorkOrder::TYPE_UNLOADING)->replaceMatches('/[_-]/', ' ') }}
                                </option>
                                <option value="{{ \App\Models\WorkOrder::TYPE_STRIPPING_CONTAINER }}"{{ old('job_type') == \App\Models\WorkOrder::TYPE_STRIPPING_CONTAINER ? ' selected' : '' }}>
                                    {{ Str::of(\App\Models\WorkOrder::TYPE_STRIPPING_CONTAINER)->replaceMatches('/[_-]/', ' ') }}
                                </option>
                                <option value="{{ \App\Models\WorkOrder::TYPE_RETURN_EMPTY_CONTAINER }}"{{ old('job_type') == \App\Models\WorkOrder::TYPE_RETURN_EMPTY_CONTAINER ? ' selected' : '' }}>
                                    {{ Str::of(\App\Models\WorkOrder::TYPE_RETURN_EMPTY_CONTAINER)->replaceMatches('/[_-]/', ' ') }}
                                </option>
                                <option value="{{ \App\Models\WorkOrder::TYPE_UNPACKING_GOODS }}"{{ old('job_type') == \App\Models\WorkOrder::TYPE_UNPACKING_GOODS ? ' selected' : '' }}>
                                    {{ Str::of(\App\Models\WorkOrder::TYPE_UNPACKING_GOODS)->replaceMatches('/[_-]/', ' ') }}
                                </option>
                                <option value="{{ \App\Models\WorkOrder::TYPE_REPACKING_GOODS }}"{{ old('job_type') == \App\Models\WorkOrder::TYPE_REPACKING_GOODS ? ' selected' : '' }}>
                                    {{ Str::of(\App\Models\WorkOrder::TYPE_REPACKING_GOODS)->replaceMatches('/[_-]/', ' ') }}
                                </option>
                                <option value="{{ \App\Models\WorkOrder::TYPE_LOADING }}"{{ old('job_type') == \App\Models\WorkOrder::TYPE_LOADING ? ' selected' : '' }}>
                                    {{ Str::of(\App\Models\WorkOrder::TYPE_LOADING)->replaceMatches('/[_-]/', ' ') }}
                                </option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                        @error('user_id') <p class="form-text-error">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="px-2 sm:w-1/2">
                    <div class="flex flex-wrap mb-3 sm:mb-4">
                        <label for="user_id" class="form-label">{{ __('Assigned Job User') }}</label>
                        <div class="relative w-full">
                            <select class="form-input pr-8" name="user_id" id="user_id">
                                <option value="">No specific user</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" data-type="{{ $user->name }}"{{ old('user_id') == $user->id ? ' selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                        @error('user_id') <p class="form-text-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap mb-3 sm:mb-4">
                <label for="description" class="form-label">{{ __('Description') }}</label>
                <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                          placeholder="Job description or instruction" name="description">{{ old('description') }}</textarea>
                @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="submit" class="button-primary button-sm ml-auto">Create Work Order</button>
        </div>
    </form>
@endsection
