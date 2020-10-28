<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveBookingRequest extends FormRequest
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
            'upload_id' => ['bail', 'required', 'numeric'],
            'customer_id' => ['bail', 'required', 'numeric'],
            'booking_type_id' => ['bail', 'required', 'numeric'],
            'reference_number' => ['required', 'max:100'],
            'supplier_name' => ['required', 'max:100'],
            'owner_name' => ['required', 'max:100'],
            'shipper_name' => ['required', 'max:100'],
            'voy_flight' => ['required', 'max:100'],
            'arrival_date' => ['required', 'date'],
            'tps' => ['required', 'max:100'],
            'total_cif' => ['nullable'],
            'total_gross_weight' => ['nullable'],
            'total_weight' => ['nullable'],
            'description' => ['max:500', 'string'],
        ];
    }
}
