<?php

namespace App\Http\Middleware;

use App\Helpers\UserHelper;
use Closure;

class AdminAction
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
        $user = UserHelper::GetUser($request);
        if($user->staff_status == 0){
            return response()->make(json_encode([
                'status' => 'ERROR',
                'message' => 'Недостаточно прав для выполнения запроса!'
            ]));
        }
        return $next($request);
    }
}
