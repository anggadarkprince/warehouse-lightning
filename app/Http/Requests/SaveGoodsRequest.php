<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveGoodsRequest extends FormRequest
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
        $goodsId = optional($this->route('goods'))->id;

        return [
            'item_name' => ['required', 'max:50', 'string'],
            'item_number' => ['required', 'max:20', 'unique:goods,item_number,' . $goodsId . ',id'],
            'unit_name' => ['nullable', 'max:50', 'string'],
            'package_name' => ['nullable', 'max:50', 'string'],
            'unit_weight' => ['nullable', 'max:20', 'string'],
            'unit_gross_weight' => ['nullable', 'max:20', 'string'],
            'description' => ['nullable', 'max:500', 'string'],
        ];
    }
}
