@extends('layouts.app')

@section('content')
    <form action="{{ route('bookings.xml-preview') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Import Booking XML</h1>
                <p class="text-gray-400 leading-tight">Upload booking xml file</p>
            </div>
            <div class="py-2">
                <div class="flex mb-3 sm:mb-4 input-file-wrapper">
                    <input type="text" readonly class="form-input input-file-label rounded-tr-none rounded-br-none" placeholder="Select XML file" aria-label="XML file">
                    <div class="relative">
                        <input class="input-file button-primary absolute block hidden top-0" type="file" name="xml" id="xml" accept="application/xml">
                        <label for="xml" class="button-choose-file button-blue py-2 px-4 rounded-tl-none rounded-bl-none border border-transparent cursor-pointer">
                            Choose XML
                        </label>
                    </div>
                    @error('xml') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-primary button-sm">Upload & Preview</button>
        </div>
    </form>
@endsection
