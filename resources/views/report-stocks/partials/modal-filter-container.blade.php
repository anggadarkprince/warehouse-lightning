<div id="modal-filter-container" class="modal">
    <div class="modal-content">
        <div class="border-b border-gray-200 pb-3">
            <span class="close dismiss-modal">&times;</span>
            <h3 class="text-xl">Filter Containers</h3>
        </div>
        <form action="{{ url()->current() }}" method="get" class="space-y-4">
            <input type="hidden" name="filter" value="container">
            <div class="flex flex-wrap">
                <label for="q" class="form-label">{{ __('Search') }}</label>
                <input id="q" type="search" class="form-input"
                       placeholder="Search data" name="q" value="{{ request()->get('q') }}">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-wrap">
                    <label for="sort_by" class="form-label">{{ __('Sort By') }}</label>
                    <div class="relative w-full">
                        <select class="form-input pr-8" name="sort_by" id="sort_by">
                            <?php
                            $sortFields = [
                                'reference_number' => 'Reference Number',
                                'booking_number' => 'Booking Number',
                                'customer_name' => 'Customer Name',
                                'container_number' => 'Container Number',
                                'container_type' => 'Container Type',
                                'container_size' => 'Container Size',
                            ]
                            ?>
                            @foreach($sortFields as $sortKey => $sortField)
                                <option value="{{ $sortKey }}"{{ request()->get('sort_by') == $sortKey ? 'selected' : '' }}>
                                    {{ $sortField }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <label for="sort_method" class="form-label">{{ __('Sort Method') }}</label>
                    <div class="relative w-full">
                        <select class="form-input pr-8" name="sort_method" id="sort_method">
                            <option value="desc"{{ request()->get('sort_method') == 'desc' ? 'selected' : '' }}>
                                Descending
                            </option>
                            <option value="asc"{{ request()->get('sort_method') == 'asc' ? 'selected' : '' }}>
                                Ascending
                            </option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <label for="container_size" class="form-label">{{ __('Container Size') }}</label>
                    <div class="relative w-full">
                        <select class="form-input pr-8" name="container_size" id="container_size">
                            <option value="">All Size</option>
                            @foreach(['20' => '20', '40' => '40', '45' => '45'] as $size => $filterSizes)
                                <option value="{{ $size }}"{{ request()->get('container_size') == $size ? 'selected' : '' }}>
                                    {{ $filterSizes }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <label for="is_empty" class="form-label">{{ __('Container Empty') }}</label>
                    <div class="relative w-full">
                        <select class="form-input pr-8" name="is_empty" id="is_empty">
                            <option value="">All Container</option>
                            <option value="0"{{ request()->get('is_empty') == 'desc' ? 'selected' : '' }}>
                                No (Loaded / Full)
                            </option>
                            <option value="1"{{ request()->get('is_empty') == 'asc' ? 'selected' : '' }}>
                                Yes (Empty)
                            </option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <label for="stock_date" class="form-label">{{ __('Stock Date') }}</label>
                    <div class="relative w-full">
                        <input id="stock_date" type="text" class="form-input datepicker" data-clear-button=".clear-date-stock" autocomplete="off"
                               placeholder="Stock date at" name="stock_date" value="{{ request()->get('stock_date') }}">
                        <span class="close absolute right-0 top-0 my-3 px-3 clear-date-stock">&times;</span>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <label for="data" class="form-label">{{ __('Data') }}</label>
                    <div class="relative w-full">
                        <select class="form-input pr-8" name="data" id="data">
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
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
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
