<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\StatusOrder;
use App\OrderMerchandise;

class Order extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function status_order() {
        return $this->belongsTo(StatusOrder::class);
    }

    public function order_merchandise() {
        return $this->belongsToMany(OrderMerchandise::class);
    } 
}
