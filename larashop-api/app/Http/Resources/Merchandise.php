<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Merchandise extends JsonResource
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
            'store_id' => $this->store_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'photo' => $this->photo,
            'description' => $this->description,
            'stock' => $this->stock,
            'price' => $this->price,
            'weight' => $this->weight,
            'condition' => $this->condition,
            'insurance' => $this->insurance,
            'view_count' => $this->view_count,
			'store_name' => $this->store->name,
            'status_store' => $this->store->status_store->name,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
