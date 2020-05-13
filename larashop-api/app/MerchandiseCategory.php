<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Merchandise;

class MerchandiseCategory extends Model
{
    public function category() {
        return $this->belongsTo(Category::class);
    } 

    public function merchandise() {
        return $this->belongsTo(Merchandise::class);
    } 
}
