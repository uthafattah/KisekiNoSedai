<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OrderMerchandise;

class Review extends Model
{
    protected $fillable = [
        'order_id', 'rating', 'comment'
    ];

    public function order_merchandise() {
		return $this->belongsTo(OrderMerchandise::class);
	}
}
