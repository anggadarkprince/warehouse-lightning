@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow px-6 py-4">
        <div class="flex justify-between items-center mb-3">
            <div>
                <h1 class="text-xl text-green-500">Customer</h1>
                <span class="text-gray-400">Manage all customer</span>
            </div>
            <div>
                <button class="button-blue button-sm modal-toggle" data-modal="#modal-filter">
                    <i class="mdi mdi-tune-vertical-variant"></i>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="button-blue button-sm text-center">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
                @can('create', \App\Models\Customer::class)
                    <a href="{{ route('customers.create') }}" class="button-blue button-sm">
                        Create <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
            <tr>
                <th class="border-b border-t px-4 py-2 w-12">No</th>
                <th class="border-b border-t px-4 py-2 text-left">Customer Name</th>
                <th class="border-b border-t px-4 py-2 text-left">PIC</th>
                <th class="border-b border-t px-4 py-2 text-left">Address</th>
                <th class="border-b border-t px-4 py-2 text-left">Phone</th>
                <th class="border-b border-t px-4 py-2 text-right">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($customers as $index => $customer)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-1 leading-tight">
                        {{ $customer->customer_name }}<br>
                        <small class="text-gray-500 text-xs">{{ $customer->customer_number }}</small>
                    </td>
                    <td class="px-4 py-1">{{ $customer->pic_name ?: '-' }}</td>
                    <td class="px-4 py-1">{{ $customer->contact_address ?: '-' }}</td>
                    <td class="px-4 py-1">{{ $customer->contact_phone ?: '-' }}</td>
                    <td class="px-4 py-1 text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                Action <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $customer)
                                    <a href="{{ route('customers.show', ['customer' => $customer->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>View
                                    </a>
                                @endcan
                                @can('update', $customer)
                                <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" class="dropdown-item">
                                    <i class="mdi mdi-square-edit-outline mr-2"></i>Edit
                                </a>
                                @endcan
                                @can('delete', $customer)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('customers.destroy', ['customer' => $customer->id]) }}" data-label="{{ $customer->customer_name }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>Delete
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No data available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $customers->withQueryString()->links() }}
    </div>

    @include('customer.partials.modal-filter')
    @include('partials.modal-delete')
@endsection
