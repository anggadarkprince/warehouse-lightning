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
                    <div class="w-full">
                        <select class="form-input select-choice" name="sort_by" id="sort_by">
                            <?php
                            $sortFields = [
                                'completed_at' => 'Completed At',
                                'job_number' => 'Job Number',
                                'reference_number' => 'Reference Number',
                                'booking_number' => 'Booking Number',
                                'customer_name' => 'Customer Name',
                                'booking_name' => 'Booking Name',
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
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <label for="sort_method" class="form-label">{{ __('Sort Method') }}</label>
                    <div class="w-full">
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
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-wrap">
                    <label for="date_from" class="form-label">{{ __('Date From') }}</label>
                    <div class="relative">
                        <input id="date_from" type="search" class="form-input datepicker" data-clear-button=".clear-date-from" autocomplete="off"
                               placeholder="Date created since" name="date_from" value="{{ request()->get('date_from') }}">
                        <span class="close clear-date-button clear-date-from">&times;</span>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <label for="date_to" class="form-label">{{ __('Date To') }}</label>
                    <div class="relative">
                        <input id="date_to" type="search" class="form-input datepicker" data-clear-button=".clear-date-to" autocomplete="off"
                               placeholder="Date created until" name="date_to" value="{{ request()->get('date_to') }}">
                        <span class="close clear-date-button clear-date-to">&times;</span>
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
