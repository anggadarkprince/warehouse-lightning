<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveDeliveryOrderRequest extends FormRequest
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
            'type' => ['bail', 'required', Rule::in(['INBOUND', 'OUTBOUND'])],
            'booking_id' => ['bail', 'required', 'integer', 'exists:bookings,id'],
            'destination' => ['bail', 'required', 'string'],
            'delivery_date' => ['bail', 'required', 'date'],
            'destination_address' => ['nullable', 'string', 'max:500'],
            'driver_name' => ['required', 'string', 'max:50'],
            'vehicle_name' => ['required', 'max:50'],
            'vehicle_type' => ['nullable', 'max:50'],
            'vehicle_plat_number' => ['required', 'max:20'],
            'description' => ['nullable', 'max:500'],
            'containers.*.container_id' => ['required', 'integer', 'exists:containers,id'],
            'goods' => ['nullable', 'array'],
            'goods.*.goods_id' => ['required', 'integer', 'exists:goods,id'],
        ];
    }
}
