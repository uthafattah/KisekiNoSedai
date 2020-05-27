<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Review extends JsonResource
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
            'order_merchandise_id' => $this->order_merchandise_id,
            'rating' => number_format($this->rating, 1),
			'comment' => $this->comment,
            'user_name' => $this->order_merchandise->order->user->name,
            'user_avatar' => $this->order_merchandise->order->user->avatar,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
