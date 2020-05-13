<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Cart extends JsonResource
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
			'user_id' => $this->user_id,
			'merchandise_id' => $this->merchandise_id,
		    'name' => $this->merchandise->name,
            'stock' => $this->merchandise->stock,
            'price' => $this->merchandise->price,
            'photo' => $this->merchandise->photo,
			'quantity' => $this->quantity,
			'created_at' => $this->created_at->format('Y-m-d H:i:s'),
			'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
		];
    }
}
