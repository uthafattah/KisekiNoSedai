<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Store;
use App\Category;

class Merchandise extends Model
{
	protected $hidden = ['pivot'];

    public function store() {
        return $this->belongsTo(Store::class);
    } 

    public function category() {
        return $this->belongsToMany(Category::class, 'merchandise_categories')->select(array('name'));
    }
}
