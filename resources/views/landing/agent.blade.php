@extends('layouts.landing')

@section('content')
    <div class="bg-gray-100 pt-10 pb-20">
        <div class="px-4 max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <p class="text-green-500 font-bold">Around The World</p>
                <h1 class="font-bold text-3xl">Global Locations</h1>
            </div>

            <h1 class="text-xl pb-3 mb-3 border-b font-bold">Asia Region</h1>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 font-semibold mb-8">
                <p><i class="mdi mdi-map-marker-outline"></i> Jakarta</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Surabaya</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Medan</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Yogyakarta</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Chennai</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Kuala Lumpur</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Seoul</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Beijing</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Jedah</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Bangkok</p>
            </div>

            <h1 class="text-xl pb-3 mb-3 border-b font-bold">Europe Region</h1>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 font-semibold mb-8">
                <p><i class="mdi mdi-map-marker-outline"></i> Roma</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Paris</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Istanbul</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Manchester</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Ukraine</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Portland</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Mersin</p>
            </div>

            <h1 class="text-xl pb-3 mb-3 border-b font-bold">America Region</h1>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 font-semibold mb-8">
                <p><i class="mdi mdi-map-marker-outline"></i> New York</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Las Vegas</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Rio</p>
                <p><i class="mdi mdi-map-marker-outline"></i> Chicago</p>
            </div>
        </div>
    </div>
@endsection
