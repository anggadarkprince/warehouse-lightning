<div class="bg-white rounded shadow-sm px-6 py-4 mb-4 document-item" id="document-item-{!! $documentTypeId !!}">
    <div class="flex items-start justify-between sm:items-center sm:justify-start border-b pb-2">
        <div class="flex flex-col flex-grow sm:flex-row sm:items-center">
            <div class="lg:w-64 sm:w-1/3 sm:mr-3">
                <h3 class="text-xl text-blue-500 document-name">{!! $documentName !!}</h3>
                <p class="text-gray-400 text-sm document-description">{!! $documentDescription !!}</p>
            </div>
            <div class="flex flex-row sm:w-1/2">
                <div class="text-gray-600 text-sm sm:text-base sm:w-1/2 mr-2 leading-tight">
                    <p class="text-xs text-gray-400 hidden sm:block">DOCUMENT NUMBER</p>
                    <p class="document-number uppercase">{!! $documentNumber !!}</p>
                </div>
                <div class="text-gray-500 text-sm sm:text-gray-600 sm:text-base sm:w-1/2 leading-tight">
                    <p class="text-xs text-gray-400 hidden sm:block">DOCUMENT DATE</p>
                    <p class="document-date uppercase">{!! $documentDate !!}</p>
                </div>
            </div>
        </div>
        <div class="ml-auto">
            <div class="relative inline-block">
                <input class="input-file absolute hidden top-0" type="file" multiple id="input_file_{!! $documentTypeId !!}">
                <label for="input_file_{!! $documentTypeId !!}" class="button-primary button-sm cursor-pointer">
                    <i class="mdi mdi-plus"></i><span class="hidden sm:inline-block">ADD FILE</span>
                </label>
            </div>
            <button type="button" class="button-blue button-sm btn-edit-document">
                <i class="mdi mdi-square-edit-outline"></i>
            </button>
            <button type="button" class="button-red button-sm btn-delete-document">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </div>
    </div>
    <ul class="list-inside pt-2 space-y-1 file-wrapper">
        <?php if(!isset($documentFiles)) $documentFiles = [] ?>
        <li class="flex items-center px-2 py-1 rounded border border-2 border-dashed file-placeholder{{ !empty($documentFiles) ? ' hidden' : '' }}">
            <p class="text-gray-500">Click add file to add document file</p>
        </li>
        @foreach($documentFiles as $index => $documentFile)
            @include('upload-documents.partials.template-upload-file', [
                'id' => key_exists('id', $documentFile) && !empty($documentFile['id']) ? $documentFile['id'] : '',
                'fileName' => $documentFile['file_name'] ?: basename($documentFile['src']),
                'uploadPercentage' => key_exists('id', $documentFile) && !empty($documentFile['id']) ? 'UPLOADED (OLD FILE)' : 'UPLOADED',
                'src' => $documentFile['src'],
                'documentTypeId' => $documentTypeId,
                'index' => $index
            ])
        @endforeach
    </ul>
    <div class="document-inputs">
        <input type="hidden" name="documents[{!! $documentTypeId !!}][id]" value="{!! $id ?? '' !!}" class="input-document-id">
        <input type="hidden" name="documents[{!! $documentTypeId !!}][document_type_id]" value="{!! $documentTypeId !!}" class="input-document-type-id">
        <input type="hidden" name="documents[{!! $documentTypeId !!}][document_name]" value="{!! $documentName !!}" class="input-document-name">
        <input type="hidden" name="documents[{!! $documentTypeId !!}][description]" value="{!! $documentDescription !!}" class="input-document-description">
        <input type="hidden" name="documents[{!! $documentTypeId !!}][document_number]" value="{!! $documentNumber !!}" class="input-document-number">
        <input type="hidden" name="documents[{!! $documentTypeId !!}][document_date]" value="{!! $documentDate !!}" class="input-document-date">
    </div>
    @error('documents.' . $documentTypeId . '.files') <p class="form-text-error">{{ $message }}</p> @enderror
</div>
