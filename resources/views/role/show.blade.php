@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2">
            <h1 class="text-xl text-green-500">Role</h1>
            <span class="text-gray-400">Account role permission</span>
        </div>
        <div class="grid sm:grid-cols-2 sm:gap-4">
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">Role Name</p>
                    <p class="text-gray-600">{{ $role->role }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Description</p>
                    <p class="text-gray-600">{{ $role->description }}</p>
                </div>
            </div>
            <div>
                <div class="flex mb-2">
                    <p class="w-1/3">Created At</p>
                    <p class="text-gray-600">{{ optional($role->created_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
                <div class="flex mb-2">
                    <p class="w-1/3">Updated At</p>
                    <p class="text-gray-600">{{ optional($role->updated_at)->format('d F Y H:i') ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
        <div class="mb-2">
            <h1 class="text-xl text-green-500">Permission Access</h1>
            <span class="text-gray-400">Choose what permission the role can do</span>
        </div>
        <div>@foreach($permissions as $moduleName => $modules)
                <h1 class="text-lg mt-4 mb-2 text-green-500">{{ ucwords(preg_replace('/(_|\-)/', ' ', $moduleName)) }}</h1>
                @foreach($modules as $featureName => $features)
                    <h2 class="text-md pl-4 mb-1 text-gray-500">{{ ucwords(preg_replace('/(_|\-)/', ' ', $featureName)) }}</h2>
                    <div class="grid grid-cols-1 gap-4 pl-4 md:grid-cols-2 lg:grid-cols-4">
                        @foreach($features as $permission)
                            <div class="mb-3">
                                <p><i class="mdi mdi-check-box-outline mr-1"></i>{{ ucwords(preg_replace('/(_|\-)/', ' ', $permission->permission)) }}</p>
                                <p class="text-sm text-gray-400 pl-5 leading-none">{{ $permission->description }}</p>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
        <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
    </div>
@endsection
