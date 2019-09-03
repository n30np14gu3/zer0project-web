<?php

namespace App\Http\Middleware;

use App\Helpers\UserHelper;
use App\Models\Ban;
use Closure;

class Action
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
        if($user == null)
            return redirect()->route('logout');

        $bans = Ban::where('user_id', $user->id)->where('active', 1)->orWhere('is_lifetime', 1)->orWhere('end_date', '>', time())->get();
        if(count($bans) != 0){
            return response()->make(json_encode([
                'status' => 'ERROR',
                'message' => 'Недостаточно прав для выполнения запроса!'
            ]));
        }
        return $next($request);
    }
}
