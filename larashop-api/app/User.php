<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Role;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'address', 'phone', 'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

	 protected $guarded = [
		'role'
	];
    
	protected $casts = [
		'email_verified_at' => 'datetime',
	];
	
	public function role() {
		return $this->belongsTo(Role::class);
	}
}
