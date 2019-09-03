<?php

namespace App\Http\Middleware;

use App\Helpers\UserHelper;
use Closure;

class AuthForms
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
        if(UserHelper::CheckAuth($request))
            return redirect()->route('dashboard');

        return $next($request);
    }
}
