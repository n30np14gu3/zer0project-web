<?php

namespace App\Helpers;

use App\Mail\CompleteRegister;
use App\Models\Ban;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserHelper
{
    /**
     * @param Request $request
     * @return bool
     */
    public static function CheckAuth(Request $request){
        if(!$request->session()->has('user_data'))
            return false;

        $session = (array)@json_decode($request->session()->get('user_data'));
        if(count($session) == 0)
            return false;

        $user = @User::where('id', $session['id'])->get()->first();
        if(!$user)
            return false;

        if($user->password != $session['password'])
            return false;

        return true;
    }

    /**
     * @param Request $request
     * @return User|null
     */
    public static function GetUser(Request $request){
        if(!self::CheckAuth($request))
            return null;

        $session = (array)@json_decode($request->session()->get('user_data'));
        return @User::where('id', $session['id'])->get()->first();
    }

    public static function RegisterUser($email, $password){
        $user = new User();
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->status = env('USER_DISABLE_CONFIRMATION') ? 1 : 0;
        $user->staff_status = 0;
        $user->save();

        if(!env('USER_DISABLE_CONFIRMATION')){
            Mail::to($user->email)->send(
                new CompleteRegister(
                    MailHelper::GenerateConfirmToken($user->id),
                    'Подтверждение регистрации',
                    'Регистрация на '.env('CHEAT_NAME')));
        }
    }

    public static function PutUserInfo(User $user){
        $session = [
            'id' => $user->id,
            'password' => $user->password
        ];

        $session = json_encode($session);
        session()->put('user_data', $session);
    }

    public static function UpdateUserPassword(Request $request, $newPassword){
        $user = self::GetUser($request);
        $user->password = Hash::make($newPassword);
        $user->save();
        self::PutUserInfo($user);
    }

    public static function CheckUserActivity(User $user){
        if($user->status == 0)
            return false;

        $bans = Ban::where('user_id', $user->id)->where('active', 1)->orWhere('is_lifetime', 1)->orWhere('end_date', '>', time())->get();
        if(count($bans) != 0)
            return false;

        return true;
    }
}
