<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Merchandise;

class Wishlist extends Model
{
	protected $fillable = [
        'user_id', 'merchandise_id',
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    } 

    public function merchandise() {
        return $this->belongsTo(Merchandise::class);
    }
}
