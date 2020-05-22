<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Store;

class Follow extends Model
{
	protected $fillable = [
        'user_id', 'store_id',
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    } 

    public function store() {
        return $this->belongsTo(Store::class);
    }
}
