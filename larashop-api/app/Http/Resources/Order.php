<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
			'total_price' => $this->total_price,
            'invoice_number' => $this->invoice_number,
            'status_order_id' => $this->status_order_id,
            'status_order' => $this->status_order->name,
			'payment_id' => $this->payment_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
