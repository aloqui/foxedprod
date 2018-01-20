<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Http\Middleware\Response;
class RedirectIfEmailNotConfirmed
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
       
        if(! $request->user()->confirmed) {
            abort(403, 'Confirm Email Address');
         }
    
        return $next($request);
    }
}
