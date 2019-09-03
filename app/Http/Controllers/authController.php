<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class authController extends Controller
{

    public function logout(Request $request){
        $request->session()->flush();
        return redirect()->route('index');
    }

    public function login(Request $request){
        $response = [
            'status' => 'ERROR',
            'message' => ''
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            $response['message'] = 'Не все поля заполнены';
            return json_encode($response);
        }

        $user = @User::where('email', $request['email'])->get()->first();
        if(!$user){
            $response['message'] = 'Пользователь с таким email не найден!';
            return json_encode($response);
        }

        if(!Hash::check($request['password'], $user->password)){
            $response['message'] = 'Неверное имя пользователя или пароль!';
            return json_encode($response);
        }

        if(Hash::needsRehash($user->password)){
            $user->password = Hash::make($request['password']);
            $user->save();
        }

        $loginHistory = new LoginHistory();
        $loginHistory->user_id = $user->id;
        $loginHistory->ip = @$_SERVER['REMOTE_ADDR'];
        $loginHistory->save();

        UserHelper::PutUserInfo($user);
        $response['status'] = 'OK';
        return json_encode($response);
    }

    public function register(Request $request){
        $response = [
            'status' => 'ERROR',
            'message' => ''
        ];

        $messages = [
            'required' => 'Не все поля заполнены',
            'same' => 'Пароли не совпадают',
            'unique' => 'Пользователь с таким email уже существует!',
            'min' => 'Минимальная длина пароля 8 символов!'
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password-2' => 'required|same:password',
        ], $messages);


        if($validator->fails()){
            $response['message'] = $validator->errors()->all();
            return json_encode($response);
        }

        UserHelper::RegisterUser($request['email'], $request['password']);
        $response['status'] = 'OK';
        return json_encode($response);
    }
}
