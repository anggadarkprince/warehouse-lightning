<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveWorkOrderRequest extends FormRequest
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
            'booking_id' => [
                Rule::requiredIf(empty($this->input('delivery_order_id'))),
                'integer',
                'exists:bookings,id'
            ],
            'delivery_order_id' => ['nullable', 'integer', 'exists:delivery_orders,id'],
            'job_type' => [
                Rule::requiredIf(empty($this->input('delivery_order_id'))),
                Rule::in(['UNLOADING', 'CONTAINER STRIPPING', 'RETURN EMPTY CONTAINER', 'REPACKING GOODS', 'UNPACKING GOODS', 'LOADING']),
            ],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'description' => ['nullable', 'max:500', 'string'],
        ];
    }
}
