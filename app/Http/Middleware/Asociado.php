<?php

namespace App\Http\Middleware;

use Closure;

class Asociado
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
        if(Auth::user()->esAsociado())
        {
            return $next($request);    
        }
        else
        {
            return redirect()->to('/');
        }
    }
}
