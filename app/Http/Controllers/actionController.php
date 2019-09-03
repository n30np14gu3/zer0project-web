<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\PromoCode;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class actionController extends Controller
{
    public function changePassword(Request $request){
        $response = [
            'status' => 'ERROR',
            'message' => []
        ];

        $messages = [
            'required' => 'Не все поля заполнены',
            'same' => 'Пароли не совпадают',
            'min' => 'Минимальная длина пароля 8 символов!'
        ];

        $validator = Validator::make($request->all(), [
            'old-password' => 'required',
            'new-password' => 'required|min:8',
            'new-password-2' => 'required|same:new-password'
        ], $messages);

        if($validator->fails()){
            $response['message'] = $validator->errors()->all();
            return json_encode($response);
        }

        $user = UserHelper::GetUser($request);
        if(!Hash::check($request['old-password'], $user->password)){
            array_push($response['message'], 'Введен неверный старый проль');
            return json_encode($response);
        }

        UserHelper::UpdateUserPassword($request, $request['new-password']);
        $response['status'] = 'OK';
        return json_encode($response);
    }

    public function activatePromo(Request $request){
        $response = [
            'status' => 'ERROR',
            'message' => []
        ];

        $messages = [
            'required' => 'Не все поля заполнены',
            'exists' => 'Данного ключа не существует'
        ];


        $validator = Validator::make($request->all(), [
            'promo-code' => 'required|exists:promo_codes,promo',
        ], $messages);

        if($validator->fails()){
            $response['message'] = $validator->errors()->all();
            return json_encode($response);
        }

        $promo = PromoCode::where('promo', $request['promo-code'])->get()->first();
        $user = UserHelper::GetUser($request);
        if($promo->user_id != 0){
            array_push($response['message'], 'Данный промокод уже активирован');
            return json_encode($response);
        }

        $same_promo = PromoCode::where('seed', $promo->seed)->where('user_id', $user->id)->get();
        if(count($same_promo) != 0){
            array_push($response['message'], 'Вы уже активировали промокод данной серии');
            return json_encode($response);
        }

        $subscription = @Subscription::where('user_id', $user->id)->where('cheat_id', $promo->cheat_id)->get()->first();
        if($subscription == null){
            $subscription = new Subscription();
            $subscription->expire_time = time() + $promo->increment;
            $subscription->status = 1;
            $subscription->user_id = $user->id;
            $subscription->cheat_id = $promo->cheat_id;
            $subscription->hwid = null;
            $subscription->save();
        }elseif($subscription->expire_time < time()){
            $subscription->expire_time = time() + $promo->increment;
            $subscription->save();
        }else{
            $subscription->expire_time += $promo->increment;
            $subscription->save();
        }

        $promo->user_id = $user->id;
        $promo->save();

        $response['status'] = "OK";
        return json_encode($response);
    }
}
