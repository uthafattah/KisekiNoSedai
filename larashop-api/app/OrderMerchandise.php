<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Merchandise;
use App\Store;

class OrderMerchandise extends Model
{
    public function merchandise() {
        return $this->belongsTo(Merchandise::class);
    } 

    public function store() {
        return $this->belongsTo(Store::class);
    } 
}
