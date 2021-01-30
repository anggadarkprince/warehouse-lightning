@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow-sm py-4">
        <div class="flex justify-between items-center mb-3 px-6">
            <div>
                <h1 class="text-xl text-green-500">{{ __('Customer') }}</h1>
                <p class="text-gray-400 leading-tight">{{ __('Manage all customer') }}</p>
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
                        {{ __('Create') }} <i class="mdi mdi-plus-box-outline"></i>
                    </a>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full mb-4 table-responsive">
            <thead>
            <tr>
                <th class="border-b border-t border-gray-200 p-2 w-12 md:text-center">{{ __('No') }}</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">{{ __('Customer Name') }}</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">{{ __('PIC') }}</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">{{ __('Address') }}</th>
                <th class="border-b border-t border-gray-200 p-2 text-left">{{ __('Phone') }}</th>
                <th class="border-b border-t border-gray-200 p-2 text-right">{{ __('Action') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($customers as $index => $customer)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-2 py-1 md:text-center">{{ $index + 1 }}</td>
                    <td class="px-2 py-1 leading-tight">
                        {{ $customer->customer_name }}<br>
                        <small class="text-gray-500 text-xs">{{ $customer->customer_number }}</small>
                    </td>
                    <td class="px-2 py-1">{{ $customer->pic_name ?: '-' }}</td>
                    <td class="px-2 py-1">{{ $customer->contact_address ?: '-' }}</td>
                    <td class="px-2 py-1">{{ $customer->contact_phone ?: '-' }}</td>
                    <td class="px-2 py-1 md:text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle button-primary button-sm">
                                Action <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('view', $customer)
                                    <a href="{{ route('customers.show', ['customer' => $customer->id]) }}" class="dropdown-item">
                                        <i class="mdi mdi-eye-outline mr-2"></i>{{ __('View') }}
                                    </a>
                                @endcan
                                @can('update', $customer)
                                <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" class="dropdown-item">
                                    <i class="mdi mdi-square-edit-outline mr-2"></i>{{ __('Edit') }}
                                </a>
                                @endcan
                                @can('delete', $customer)
                                    <hr class="border-gray-200 my-1">
                                    <button type="button" data-href="{{ route('customers.destroy', ['customer' => $customer->id]) }}" data-label="{{ $customer->customer_name }}" class="dropdown-item confirm-delete">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i>{{ __('Delete') }}
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-2" colspan="6">{{ __('No data available') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="px-6">
            {{ $customers->withQueryString()->links() }}
        </div>
    </div>

    @include('customer.partials.modal-filter')
    @include('partials.modal-delete')
@endsection
