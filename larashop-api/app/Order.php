<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\StatusOrder;
use App\Payment;

class Order extends Model
{
	protected $fillable = [
        'user_id', 'total_price', 'invoice_number', 'status_order_id', 'payment_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function status_order() {
        return $this->belongsTo(StatusOrder::class);
    }

    public function payment() {
        return $this->belongsTo(Payment::class);
    }
}
