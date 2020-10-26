<li class="flex items-center file-item">
    <p class="file-name w-1/2 text-sm mr-3 truncate lg:w-64 sm:w-1/3 sm:text-base">
        {!! $fileName !!}
    </p>
    <div class="flex flex-no-wrap items-center">
        <div class="w-16 sm:w-32 h-3 bg-gray-200 rounded-sm mr-2">
            <div class="h-3 bg-green-500 rounded-sm upload-progress" style="width: {!! $uploadPercentage ?? '100%' !!};"></div>
        </div>
        <span class="text-sm text-gray-500 upload-percentage">{!! $uploadPercentage ?? '100%' !!}</span>
    </div>
    <button type="button" class="ml-auto button-orange px-2 py-1 text-sm btn-delete-file" disabled>
        <i class="mdi mdi-trash-can-outline"></i>
    </button>
    <input type="hidden" name="documents[{!! $documentTypeId !!}][files][{!! $index ?? '' !!}][id]" value="{!! $id ?? '' !!}" class="input-file-id">
    <input type="hidden" name="documents[{!! $documentTypeId !!}][files][{!! $index ?? '' !!}][file_name]" value="{!! $fileName ?? '' !!}" class="input-file-name">
    <input type="hidden" name="documents[{!! $documentTypeId !!}][files][{!! $index ?? '' !!}][src]" value="{!! $src ?? '' !!}" class="input-file-src">
</li>
