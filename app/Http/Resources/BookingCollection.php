<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookingCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => BookingResource::collection($this->collection),
            'meta' => ['count' => $this->collection->count()]
        ];
    }
}
