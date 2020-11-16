<div id="modal-filter-goods" class="modal">
    <div class="modal-content">
        <div class="border-b border-gray-200 pb-3">
            <span class="close dismiss-modal">&times;</span>
            <h3 class="text-xl">Filter Goods</h3>
        </div>
        <form action="{{ url()->current() }}" method="get" class="space-y-4">
            <input type="hidden" name="filter" value="goods">
            <div class="flex flex-wrap">
                <label for="q" class="form-label">{{ __('Search') }}</label>
                <input id="q" type="search" class="form-input"
                       placeholder="Search data" name="q" value="{{ request()->get('q') }}">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-wrap">
                    <label for="sort_by" class="form-label">{{ __('Sort By') }}</label>
                    <div class="w-full">
                        <select class="form-input select-choice" name="sort_by" id="sort_by">
                            <?php
                            $sortFields = [
                                'reference_number' => 'Reference Number',
                                'booking_number' => 'Booking Number',
                                'customer_name' => 'Customer Name',
                                'booking_name' => 'Booking Name',
                                'item_number' => 'Item Number',
                                'item_name' => 'Item Name',
                                'unit_quantity' => 'Unit Quantity',
                                'package_quantity' => 'Package Quantity',
                            ]
                            ?>
                            @foreach($sortFields as $sortKey => $sortField)
                                <option value="{{ $sortKey }}"{{ request()->get('sort_by') == $sortKey ? 'selected' : '' }}>
                                    {{ $sortField }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <label for="sort_method" class="form-label">{{ __('Sort Method') }}</label>
                    <div class="relative w-full">
                        <select class="form-input select-choice" name="sort_method" id="sort_method" data-search-enable="false">
                            <option value="desc"{{ request()->get('sort_method') == 'desc' ? 'selected' : '' }}>
                                Descending
                            </option>
                            <option value="asc"{{ request()->get('sort_method') == 'asc' ? 'selected' : '' }}>
                                Ascending
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap">
                <label for="stock_date" class="form-label">{{ __('Stock Date') }}</label>
                <div class="relative w-full">
                    <input id="stock_date" type="text" class="form-input datepicker" data-clear-button=".clear-date-stock-goods" autocomplete="off"
                           placeholder="Stock date at" name="stock_date" value="{{ request()->get('stock_date') }}">
                    <span class="close clear-date-button clear-date-stock-goods">&times;</span>
                </div>
            </div>
            <div class="flex flex-wrap">
                <label for="data" class="form-label">{{ __('Data') }}</label>
                <div class="w-full">
                    <select class="form-input select-choice" name="data" id="data" data-search-enable="false">
                        <?php
                        $dataStocks = [
                            'stock' => 'Stock (Available only)',
                            'all' => 'All (Whole item data)',
                            'empty-stock' => 'Empty Stock (Zero stock only)',
                            'negative-stock' => 'Negative Stock (Negative stock only)',
                            'inactive-stock' => 'Inactive Stock (Zero and negative stock)',
                        ]
                        ?>
                        @foreach($dataStocks as $key => $dataStock)
                            <option value="{{ $key }}"{{ request()->get('data') == $key ? 'selected' : '' }}>
                                {{ $dataStock }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="border-t border-gray-200 text-right pt-4">
                <a href="{{ url()->current() }}" class="button-light button-sm dismiss-modal px-5">Reset</a>
                <button type="button" class="button-light button-sm dismiss-modal px-5">Close</button>
                <button type="submit" class="button-primary button-sm px-5">Apply</button>
            </div>
        </form>
    </div>
</div>
