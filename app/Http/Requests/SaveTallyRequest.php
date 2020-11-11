<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveTallyRequest extends FormRequest
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
            'containers' => ['nullable', 'array'],
            'containers.*.container_id' => ['required', 'integer', 'exists:containers,id'],
            'goods' => ['nullable', 'array'],
            'goods.*.goods_id' => ['required', 'integer', 'exists:goods,id'],
        ];
    }
}
