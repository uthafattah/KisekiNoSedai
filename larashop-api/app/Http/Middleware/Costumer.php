<?php

/*namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Costumer
{
	private $auth;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
/*    public function handle($request, Closure $next)
    {
        $this->auth = 
			auth()->user() ?
				(auth()->user()->role === 'costumer')
				: false;
				
		if($this->auth === true)
			return $next($request);
		
		return redirect()->route('login')->with('error', 'Access denied. Login to continue.');
    }
}
