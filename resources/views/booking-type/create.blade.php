@extends('layouts.app')

@section('content')
    <form action="{{ route('booking-types.store') }}" method="post">
        @csrf
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">{{ __('Create Booking Type') }}</h1>
                <p class="text-gray-400 leading-tight">{{ __('Manage all booking type') }}</p>
            </div>
            @include('booking-type.partials.form', ['bookingType' => null])
        </div>
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">{{ __('Back') }}</button>
            <button type="submit" class="button-primary button-sm">{{ __('Save Booking Type') }}</button>
        </div>
    </form>
@endsection
