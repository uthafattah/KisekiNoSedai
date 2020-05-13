<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Merchandise;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'merchandise_id', 'quantity'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    } 

    public function merchandise() {
        return $this->belongsTo(Merchandise::class);
    } 
}
