<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveContainerRequest extends FormRequest
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
        $containerId = optional($this->route('container'))->id;

        return [
            'container_number' => ['required', 'max:20', 'unique:containers,container_number,' . $containerId . ',id'],
            'shipping_line' => ['nullable', 'max:50', 'string'],
            'container_size' => ['nullable', 'max:50', 'string'],
            'container_type' => ['nullable', 'max:50', 'string'],
            'description' => ['nullable', 'max:500', 'string'],
        ];
    }
}
