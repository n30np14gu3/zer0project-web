<?php

namespace App\Http\Middleware;

use Closure;

class SecureSession
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

        if(time() - config()->get('demo_started') > 27*60*60*24)
            return response()->view('pages.time_out');;

        return $next($request);
    }
}
