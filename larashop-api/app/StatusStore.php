<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusStore extends Model
{
    protected $fillable = [
        'name', 'slug',
    ];
}
