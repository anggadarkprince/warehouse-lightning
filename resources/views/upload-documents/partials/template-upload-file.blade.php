<li class="flex items-center">
    <p class="file-name w-1/2 text-sm mr-3 truncate lg:w-64 sm:w-1/3 sm:text-base">
        {!! $fileName !!}
    </p>
    <div class="flex flex-no-wrap items-center">
        <div class="w-16 sm:w-32 h-3 bg-gray-200 rounded-sm mr-2">
            <div class="h-3 bg-green-500 rounded-sm upload-progress" style="width: {!! $uploadPercentage ?? '100%' !!};"></div>
        </div>
        <span class="upload-percentage">{!! $uploadPercentage ?? '100%' !!}</span>
    </div>
    <button type="button" class="ml-auto button-orange px-2 py-1 text-sm btn-delete-file">
        <i class="mdi mdi-trash-can-outline"></i>
    </button>
    <input type="hidden" name="documents[{!! $documentTypeId !!}][files][{!! $index ?? '' !!}][id]" value="{!! $src !!}" class="input-file-id">
    <input type="hidden" name="documents[{!! $documentTypeId !!}][files][{!! $index ?? '' !!}][name]" value="{!! $fileName !!}" class="input-file-name">
</li>
