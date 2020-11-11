<div id="modal-form-container" class="modal">
    <div class="modal-content">
        <div class="border-b border-gray-200 pb-3">
            <span class="close dismiss-modal">&times;</span>
            <h3 class="text-xl">Container</h3>
        </div>
        <form action="#" method="get" class="pt-3 static-form space-y-4">
            <div class="flex flex-wrap">
                <label for="container_id" class="form-label">{{ __('Container') }}</label>
                <div class="relative w-full">
                    <select class="form-input pr-8" name="container_id" id="container_id" required>
                        <option value="">-- Select Container --</option>
                        @foreach($containers as $container)
                            <option value="{{ $container->id }}"
                                    data-container-number="{{ $container->container_number }}"
                                    data-container-type="{{ $container->container_type }}"
                                    data-container-size="{{ $container->container_size }}">
                                {{ $container->container_number }} - {{ $container->container_size }}, {{ $container->container_type }}
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
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-wrap">
                    <label for="container_seal" class="form-label">{{ __('Seal') }}</label>
                    <input id="container_seal" name="container_seal" type="text" class="form-input" autocomplete="off"
                           placeholder="Seal number">
                </div>
                <div class="flex flex-wrap">
                    <label for="container_is_empty" class="form-label">{{ __('Is Empty') }}</label>
                    <div class="relative w-full">
                        <select class="form-input pr-8" name="container_is_empty" id="container_is_empty" required>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap">
                <label for="container_description" class="form-label">{{ __('Description') }}</label>
                <textarea id="container_description" type="text" class="form-input"
                          placeholder="Container description" name="container_description"></textarea>
            </div>
            <div class="border-t border-gray-200 text-right pt-4">
                <button type="button" class="button-light button-sm dismiss-modal px-5">Close</button>
                <button type="submit" class="button-primary button-sm px-5">Save</button>
            </div>
        </form>
    </div>
</div>

<script id="container-row-template" type="x-tmpl-mustache">
    @include('tally.editors.template-container-row', [
        'containerNumber' => '@{{ container_number }}',
        'containerSize' => '@{{ container_size }}',
        'containerType' => '@{{ container_type }}',
        'isEmptyLabel' => '@{{ is_empty_label }}',
        'isEmpty' => '@{{ is_empty }}',
        'seal' => '@{{ seal }}',
        'description' => '@{{ description }}',
        'containerId' => '@{{ container_id }}',
    ])
</script>
