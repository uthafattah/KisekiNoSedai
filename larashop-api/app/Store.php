<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\StatusStore;
use App\Category;
use App\StoreCategory;

class Store extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    } 

    public function status_store() {
        return $this->belongsTo(StatusStore::class);
    }
}
