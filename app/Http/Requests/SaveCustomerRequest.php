<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCustomerRequest extends FormRequest
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
        $customerId = optional($this->route('customer'))->id;

        return [
            'customer_name' => ['required', 'min:3'],
            'customer_number' => ['required', 'max:50', 'unique:customers,customer_number,' . $customerId . ',id'],
            'pic_name' => ['nullable', 'max:50', 'string'],
            'contact_address' => ['nullable', 'max:50', 'string'],
            'contact_phone' => ['nullable', 'max:50', 'string'],
            'contact_email' => ['nullable', 'max:50', 'email'],
            'description' => ['nullable', 'max:500', 'string'],
        ];
    }
}
