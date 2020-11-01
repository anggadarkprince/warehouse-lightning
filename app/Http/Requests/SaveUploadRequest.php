<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => ['bail', 'required', 'numeric'],
            'booking_type_id' => ['bail', 'required', 'numeric'],
            'upload_title' => ['required', 'max:50'],
            'description' => ['max:500', 'string'],
            'documents' => ['present', 'filled', 'array'],
            'documents.*.document_type_id' => ['required', 'numeric'],
            'documents.*.document_name' => ['required'],
            'documents.*.description' => ['nullable'],
            'documents.*.document_number' => ['required', 'max:50'],
            'documents.*.document_date' => ['required', 'date'],
            'documents.*.files' => ['present', 'filled', 'array'],
            'documents.*.files.*.file_name' => ['required'],
            'documents.*.files.*.src' => ['required'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'customer_id' => 'Customer name',
            'booking_type_id' => 'Booking type name',
            'documents.*.files' => 'Document file',
            'documents.*.files.*.file_name' => 'Source file',
            'documents.*.files.*.src' => 'Source file',
        ];
    }
}
