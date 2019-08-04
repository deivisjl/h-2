<?php

namespace App\Http\Middleware;

use Closure;

class Digitador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->esDigitador())
        {
            return $next($request);    
        }
        else
        {
            return redirect()->to('/');
        }
    }
}
