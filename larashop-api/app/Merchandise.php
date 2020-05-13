<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Store;
use App\Category;
use App\MerchandiseCategory;

class Merchandise extends Model
{
    public function store() {
        return $this->belongsTo(Store::class);
    } 

    public function category() {
        return $this->belongsTo(Category::class);
    } 

    public function merchandise_category() {
        return $this->belongsToMany(MerchandiseCategory::class);
    } 
}
