<?php


namespace App\Helpers;


use App\Models\ApiRequest;
use App\Models\Subscription;
use App\Models\User;

class ApiHelper
{
    public static function CheckToken($token, $game_id = 0){
        $ip = $_SERVER['REMOTE_ADDR'];
        $current_time = time();

        $api_request = ApiRequest::where('token', $token)->where('cheat_id', $game_id)->get()->first();

        if(!$api_request)
            return false;

        if($api_request->ip != $ip)
            return false;

        if($current_time - strtotime($api_request->created_at) > 60*60*24)
            return false;

        $user = @User::where('id', $api_request->user_id)->get()->first();
        if(!UserHelper::CheckUserActivity($user))
            return false;


        $user_sub = @Subscription::where('user_id', $user->id)->where('cheat_id', $game_id)->where('expire_time', '>', time())->get()->first();
        if(!$user_sub)
            return false;

        return true;
    }
}
