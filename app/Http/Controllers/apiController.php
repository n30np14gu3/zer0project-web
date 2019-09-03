<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Helpers\UserHelper;
use App\Models\ApiRequest;
use App\Models\Cheat;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class apiController extends Controller
{
    public function login(Request $request){
        $response = [
            'code' => env('API_CODE_UNKNOWN_ERROR'),
            'data' => null,
        ];

        $messages = [
            'required' => env('API_CODE_UNKNOWN_ERROR'),
            'exists.game_id' => env('API_CODE_GAME_NOT_FOUND'),
            'exists' => env('API_CODE_USER_NOT_FOUND'),
            'email' => env('API_CODE_USER_NOT_FOUND'),
        ];

        $user_ip = $_SERVER['REMOTE_ADDR'];

        $validator = Validator::make($request->all(), [
            'game_id' => 'required|exists:cheats,id',
            'email' => 'required|exists:users,email',
            'hwid' => 'required',
            'password' => 'required',
        ], $messages);

        if($validator->fails()){
            $response['code'] = $validator->errors()->first();
            return json_encode($response);
        }

        $user = User::where('email', $request['email'])->get()->first();

        if(!Hash::check($request['password'], $user->password)){
            $response['code'] = env('API_CODE_USER_NOT_FOUND');
            return json_encode($response);
        }

        if(!UserHelper::CheckUserActivity($user)){
            $response['code'] = env('API_CODE_USER_BLOCKED');
            return json_encode($response);
        }

        $user_sub = @Subscription::where('user_id', $user->id)->where('cheat_id', $request['game_id'])->where('expire_time', '>', time())->get()->first();
        $cheat = Cheat::where('id', $request['game_id'])->get()->first();

        if(!$user_sub){
            $response['code'] = env('API_CODE_SUBSCRIPTION_EXPIRY');
            return json_encode($response);
        }

        if($user_sub->hwid && $user_sub->hwid != $request['hwid']){
            $response['code'] = env('API_CODE_HWID_ERROR');
            return json_encode($response);
        }

        if(!$user_sub->hwid){
            $user_sub->hwid = $request['hwid'];
            $user_sub->save();
        }


        $api_request = new ApiRequest();
        $api_request->user_id = $user->id;
        $api_request->cheat_id = $user_sub->cheat_id;
        $api_request->ip = $user_ip;
        $api_request->token = hash("sha256", base64_encode(openssl_random_pseudo_bytes(64)).time());
        $api_request->save();

        $response['code'] = env('API_CODE_OK');
        $response['data'] = [
            'game_name' => $cheat->name,
            'process_name' => $cheat->process_name,
            'access_token' => $api_request->token,
            'end_date' => date("d-m-Y H:i:s", $user_sub->expire_time)
        ];

        return json_encode($response);
    }

    public function requestUpdates(Request $request){
        $response = [
            'code' => env('API_CODE_UNKNOWN_ERROR'),
            'data' => null,
        ];

        $messages = [
            'required' => env('API_CODE_UNKNOWN_ERROR'),
            'exists' => env('API_CODE_GAME_NOT_FOUND'),
        ];

        $validator = Validator::make($request->all(), [
            'game_id' => 'required|exists:cheats,id',
        ], $messages);

        if($validator->fails()){
            $response['code'] = $validator->errors()->first();
            return json_encode($response);
        }

        $cheat = Cheat::where('id', $request['game_id'])->get()->first();

        if($cheat->active != 1){
            $response['code'] = env('API_CODE_GAME_DISABLED');
            return json_encode($response);
        }

        $response['data'] = [
            'last_update' => date("Y-m-d H:i:s", $cheat->last_update)
        ];

        $response['code'] = env('API_CODE_OK');
        return json_encode($response);
    }

    public function download(Request $request){
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'game_id' => 'required',
        ]);


        if($validator->fails())
            return "";

        if(!ApiHelper::CheckToken($request['access_token'], $request['game_id']))
            return "";

        $cheat = Cheat::where('id', $request['game_id'])->get()->first();

        return response()->download(storage_path("app/libs/$cheat->dll_path"), 'dll.dll');
    }
}
