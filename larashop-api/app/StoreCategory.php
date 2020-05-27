<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Store;
use App\Category;

class StoreCategory extends Model
{
    public function store() {
        return $this->belongsTo(Store::class);
    } 

    public function category() {
        return $this->belongsTo(Category::class);
    } 
}
