<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Merchandise;
use App\Store;
use App\Order;

class OrderMerchandise extends Model
{
	protected $fillable = [
        'order_id', 'merchandise_id', 'quantity', 'note',
    ];

    public function merchandise() {
        return $this->belongsTo(Merchandise::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
