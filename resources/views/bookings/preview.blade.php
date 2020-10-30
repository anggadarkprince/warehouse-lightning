@extends('layouts.app')

@section('content')
    <form action="{{ route('bookings.store-import') }}" method="post">
        @csrf
        <input type="hidden" name="xml" value="{{ request()->input('file') }}">
        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Preview Booking XML</h1>
                <span class="text-gray-400">Manage booking data</span>
            </div>
            <div class="py-2">
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="upload_id" class="form-label">{{ __('Upload') }}</label>
                    <div class="relative w-full">
                        <select class="form-input pr-8" name="upload_id" id="upload_id">
                            <option value="">-- Select upload --</option>
                            @foreach($uploads as $upload)
                                <option value="{{ $upload->id }}"{{ old('upload_id') == $upload->id ? ' selected' : '' }}>
                                    {{ $upload->bookingType->type }}: {{ $upload->upload_number }} - {{ $upload->customer->customer_name }} ({{ $upload->upload_title }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                    @error('upload_id') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2">
                <h1 class="text-xl text-green-500">Booking Detail</h1>
                <span class="text-gray-400">Information about the booking</span>
            </div>
            <div class="py-2">
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="reference_number" class="form-label">{{ __('Reference Number') }}</label>
                    <input id="reference_number" name="reference_number" type="text" class="form-input @error('reference_number') border-red-500 @enderror"
                           placeholder="Reference number" value="{{ old('reference_number', $booking['reference_number']) }}" required maxlength="100" readonly>
                    @error('reference_number') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="supplier_name" class="form-label">{{ __('Supplier Name') }}</label>
                            <input id="supplier_name" name="supplier_name" type="text" class="form-input @error('supplier_name') border-red-500 @enderror"
                                   placeholder="Reference number" value="{{ old('supplier_name', $booking['supplier_name']) }}" required maxlength="100" readonly>
                            @error('supplier_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="owner_name" class="form-label">{{ __('Owner Name') }}</label>
                            <input id="owner_name" name="owner_name" type="text" class="form-input @error('owner_name') border-red-500 @enderror"
                                   placeholder="Owner name" value="{{ old('owner_name', $booking['owner_name']) }}" required maxlength="100" readonly>
                            @error('owner_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="shipper_name" class="form-label">{{ __('Shipper Name') }}</label>
                            <input id="shipper_name" name="shipper_name" type="text" class="form-input @error('shipper_name') border-red-500 @enderror"
                                   placeholder="Shipper name" value="{{ old('shipper_name', $booking['shipper_name']) }}" required maxlength="100" readonly>
                            @error('shipper_name') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="voy_flight" class="form-label">{{ __('Voy Flight') }}</label>
                            <input id="voy_flight" name="voy_flight" type="text" class="form-input @error('voy_flight') border-red-500 @enderror"
                                   placeholder="Voy flight number" value="{{ old('voy_flight', $booking['voy_flight']) }}" required maxlength="50" readonly>
                            @error('voy_flight') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="arrival_date" class="form-label">{{ __('Arrival Date') }}</label>
                            <input id="arrival_date" name="arrival_date" type="text" class="form-input @error('arrival_date') border-red-500 @enderror" readonly
                                   placeholder="ATA of delivery" value="{{ old('arrival_date', \Carbon\Carbon::parse($booking['arrival_date'])->format('d F Y')) }}" data-clear-button=".clear-ata" maxlength="20" autocomplete="off">
                            @error('arrival_date') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="tps" class="form-label">{{ __('TPS') }}</label>
                            <input id="tps" name="tps" type="text" class="form-input @error('tps') border-red-500 @enderror"
                                   placeholder="TPS of destination" value="{{ old('tps', $booking['tps']) }}" maxlength="50" readonly>
                            @error('tps') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="py-2">
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="total_cif" class="form-label">{{ __('Total CIF') }}</label>
                    <input id="total_cif" name="total_cif" type="text" class="form-input input-numeric @error('total_cif') border-red-500 @enderror"
                           placeholder="Total CIF of goods" value="{{ old('total_cif', numeric($booking['total_cif'])) }}" maxlength="50" readonly>
                    @error('total_cif') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
                <div class="sm:flex -mx-2">
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="total_gross_weight" class="form-label">{{ __('Total Gross Weight') }}</label>
                            <div class="flex w-full">
                                <input id="total_gross_weight" name="total_gross_weight" type="text" class="form-input input-numeric rounded-tr-none rounded-br-none @error('total_gross_weight') border-red-500 @enderror"
                                       placeholder="Total gross weight of goods" value="{{ old('total_gross_weight', numeric($booking['total_gross_weight'])) }}" maxlength="25" readonly>
                                <span class="relative button-light py-2 px-4 rounded-tl-none rounded-bl-none border border-transparent">
                                    KG
                                </span>
                            </div>
                            @error('total_gross_weight') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="px-2 sm:w-1/2">
                        <div class="flex flex-wrap mb-3 sm:mb-4">
                            <label for="total_weight" class="form-label">{{ __('Total Net Weight') }}</label>
                            <div class="flex w-full">
                                <input id="total_weight" name="total_weight" type="text" class="form-input input-numeric rounded-tr-none rounded-br-none @error('total_weight') border-red-500 @enderror"
                                       placeholder="Total net weight of goods" value="{{ old('total_weight', numeric($booking['total_weight'])) }}" maxlength="25" readonly>
                                <span class="relative button-light py-2 px-4 rounded-tl-none rounded-bl-none border border-transparent">
                                    KG
                                </span>
                            </div>
                            @error('total_weight') <p class="form-text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap mb-3 sm:mb-4">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="description" type="text" class="form-input @error('description') border-red-500 @enderror"
                              placeholder="Booking description" name="description">{{ old('description', $booking['description']) }}</textarea>
                    @error('description') <p class="form-text-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2 flex justify-between items-center">
                <div>
                    <h1 class="text-xl text-green-500">Containers</h1>
                    <span class="text-gray-400">List of booking container</span>
                </div>
            </div>
            <table class="table-auto w-full mb-4">
                <thead>
                <tr>
                    <th class="border-b border-t px-4 py-2 w-12">{{ __('No') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Container Number') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Size') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Type') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Is Empty') }}</th>
                    <th class="border-b border-t px-4 py-2 text-right">{{ __('Status') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($booking['containers'] as $index => $container)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-1">{{ $container['container_number'] }}</td>
                        <td class="px-4 py-1">{{ $container['container_size'] }}</td>
                        <td class="px-4 py-1">{{ $container['container_type'] }}</td>
                        <td class="px-4 py-1">{{ 'No' }}</td>
                        <td class="px-4 py-1 text-right">
                            @if(empty($container['id']))
                                <span class="ml-2 px-1 bg-red-500 text-white text-xs">
                                    NEW
                                </span>
                            @else
                                <span class="ml-2 px-1 bg-green-500 text-white text-xs">
                                    EXISTING
                                </span>
                            @endif
                            <input type="hidden" name="containers[{{ $index }}][container_id]" value="{{ $container['container_id'] }}">
                            <input type="hidden" name="containers[{{ $index }}][container_number]" value="{{ $container['container_number'] }}">
                            <input type="hidden" name="containers[{{ $index }}][container_size]" value="{{ $container['container_size'] }}">
                            <input type="hidden" name="containers[{{ $index }}][container_type]" value="{{ $container['container_type'] }}">
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">{{ __('No data available') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4">
            <div class="mb-2 flex justify-between items-center">
                <div>
                    <h1 class="text-xl text-green-500">Goods</h1>
                    <span class="text-gray-400">List of booking goods</span>
                </div>
            </div>
            <table class="table-auto w-full mb-4">
                <thead>
                <tr>
                    <th class="border-b border-t px-4 py-2 w-12">{{ __('No') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Item Name') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Item Number') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Unit Qty') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Unit Name') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Package Qty') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Package Name') }}</th>
                    <th class="border-b border-t px-4 py-2 text-left">{{ __('Weight') }}</th>
                    <th class="border-b border-t px-4 py-2 text-right">{{ __('Status') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($booking['goods'] as $index => $goods)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="px-4 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-1" style="min-width: 200px">{{ $goods['item_name'] }}</td>
                        <td class="px-4 py-1" title="{{ $goods['item_number'] }}">{{ mid_ellipsis($goods['item_number']) }}</td>
                        <td class="px-4 py-1">{{ numeric($goods['unit_quantity']) }}</td>
                        <td class="px-4 py-1">{{ $goods['unit_name'] }}</td>
                        <td class="px-4 py-1">{{ numeric($goods['package_quantity']) }}</td>
                        <td class="px-4 py-1">{{ $goods['package_name'] }}</td>
                        <td class="px-4 py-1">{{ $goods['weight'] }}</td>
                        <td class="px-4 py-1 text-right">
                            @if(empty($goods['id']))
                                <span class="ml-2 px-1 bg-red-500 text-white text-xs">
                                    NEW
                                </span>
                            @else
                                <span class="ml-2 px-1 bg-green-500 text-white text-xs">
                                    EXISTING
                                </span>
                            @endif
                            <input type="hidden" name="goods[{{ $index }}][goods_id]" value="{{ $goods['goods_id'] }}">
                            <input type="hidden" name="goods[{{ $index }}][item_name]" value="{{ $goods['item_name'] }}">
                            <input type="hidden" name="goods[{{ $index }}][item_number]" value="{{ $goods['item_number'] }}">
                            <input type="hidden" name="goods[{{ $index }}][unit_quantity]" value="{{ $goods['unit_quantity'] }}">
                            <input type="hidden" name="goods[{{ $index }}][unit_name]" value="{{ $goods['unit_name'] }}">
                            <input type="hidden" name="goods[{{ $index }}][package_quantity]" value="{{ $goods['package_quantity'] }}">
                            <input type="hidden" name="goods[{{ $index }}][package_name]" value="{{ $goods['package_name'] }}">
                            <input type="hidden" name="goods[{{ $index }}][weight]" value="{{ $goods['weight'] }}">
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">{{ __('No data available') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded shadow-sm px-6 py-4 mb-4 flex justify-between">
            <button type="button" onclick="history.back()" class="button-blue button-sm">Back</button>
            <button type="submit" class="button-primary button-sm">Import Booking</button>
        </div>
    </form>
@endsection
