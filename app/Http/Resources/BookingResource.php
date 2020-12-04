<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'id' => $this->id,
            'booking_number' => $this->booking_number,
            'reference_number' => $this->reference_number,
            'containers' => [
                'container' => $this->bookingContainer->container,
                'seal' => $this->bookingContainer->seal,
                'is_empty' => $this->bookingContainer->seal,
                'quantity' => $this->bookingContainer->quantity,
            ],
            'goods' => [
                'item' => [
                    'item_name' => $this->bookingGoods->goods->item->item_name,
                    'item_number' => $this->bookingGoods->goods->item->item_name,
                    'unit_name' => $this->bookingGoods->goods->item->unit_name,
                    'package_name' => $this->bookingGoods->goods->item->package_name,
                    'unit_weight' => $this->bookingGoods->goods->item->unit_weight,
                    'unit_gross_weight' => $this->bookingGoods->goods->item->unit_gross_weight,
                ],
                'unit_quantity' => $this->bookingGoods->unit_quantity,
                'package_quantity' => $this->bookingGoods->package_quantity,
                'weight' => $this->bookingGoods->weight,
                'gross_weight' => $this->bookingGoods->gross_weight,
                'description' => $this->bookingGoods->description,
            ],
            'customer' => [
                'customer_name' => $this->customer->customer_name,
                'customer_number' => $this->customer->customer_number,
                'pic_name' => $this->customer->pic_name,
                'contact_email' => $this->customer->contact_email,
                'contact_phone' => $this->customer->contact_phone,
            ],
        ];
    }
}
