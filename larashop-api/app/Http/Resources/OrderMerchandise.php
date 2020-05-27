<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderMerchandise extends JsonResource
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
            'id' => $this->id,
			'order_id' => $this->order_id,
			'merchandise_id' => $this->merchandise_id,
            'store_name' => $this->merchandise->store->name,
            'merchandise_name' => $this->merchandise->name,
            'photo' => $this->merchandise->photo,
            'price' => $this->merchandise->price,
            'quantity' => $this->quantity,
            'note' => $this->note,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
