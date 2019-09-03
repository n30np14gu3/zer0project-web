<?php

namespace App\Http\Controllers;

use App\Models\Cheat;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class adminActionController extends Controller
{
    public function createCheat(Request $request){
        $response = [
            'status' => 'ERROR',
            'message' => []
        ];

        $messages = [
            'required' => 'Не все поля заполнены',
        ];

        $validator = Validator::make($request->all(), [
            'cheat-name' => 'required',
            'process-name' => 'required',
        ], $messages);

        if($validator->fails()){
            $response['message'] = $validator->errors()->all();
            return json_encode($response);
        }

        $loader = @$request->file('game-loader');
        $libs = @$request->file('game-dll');

        if(@$loader->getClientMimeType() != "application/x-zip-compressed"){
            array_push($response['message'],'Лоадер должен быть в видео архива!');
            return json_encode($response);
        }

        $loader_name = hash("sha256", openssl_random_pseudo_bytes(64).time()).".zip";
        $dll_name = hash("sha256", openssl_random_pseudo_bytes(64).(time() + 64)).".dll";

        if(!$loader->move(storage_path('app/loaders'), $loader_name)){
            array_push($response['message'],'Не удалось загрузить лоадер на сервер!');
            return json_encode($response);
        }

        if(!$libs->move(storage_path('app/libs'), $dll_name)){
            array_push($response['message'],'Не удалось загрузить библиотеки на сервер!');
            return json_encode($response);
        }

        $cheat = new Cheat();
        $cheat->last_update = time();
        $cheat->name = $request['cheat-name'];
        $cheat->process_name = $request['process-name'];
        $cheat->active = 1;
        $cheat->dll_path = $dll_name;
        $cheat->loader_path = $loader_name;
        $cheat->save();

        $response['status'] = 'OK';
        return json_encode($response);
    }

    public function getInfo(Request $request){
        $response = [
            'status' => 'ERROR',
            'message' => [],
            'response' => [
                'process_name' => ''
            ]
        ];

        $messages = [
            'required' => 'Не все поля заполнены',
            'exists' => 'Данного чита не существует',
        ];

        $validator = Validator::make($request->all(), [
            'cheat-id' => 'required|exists:cheats,id',
        ], $messages);

        if($validator->fails()){
            $response['message'] = $validator->errors()->all();
            return json_encode($response);
        }

        $cheat = Cheat::where('id', $request['cheat-id'])->get()->first();
        $response['response']['process_name'] = $cheat->process_name;
        $response['status'] = 'OK';
        return json_encode($response);
    }

    public function updateCheat(Request $request){
        $response = [
            'status' => 'ERROR',
            'message' => []
        ];

        $messages = [
            'required' => 'Не все поля заполнены',
            'exists' => 'Данного чита не существует',
        ];

        $validator = Validator::make($request->all(), [
            'cheat-id' => 'required|exists:cheats,id',
            'process-name' => 'required',
        ], $messages);

        if($validator->fails()){
            $response['message'] = $validator->errors()->all();
            return json_encode($response);
        }

        $game_loader = $request->file('game-loader');
        $game_dll = @$request->file('game-dll');

        $cheat = Cheat::where('id', $request['cheat-id'])->get()->first();
        $cheat->process_name = $request['process-name'];

        if($game_loader){
            if(@$game_loader->getClientMimeType() != "application/x-zip-compressed"){
                array_push($response['message'],'Лоадер должен быть в видео архива!');
                return json_encode($response);
            }

            if(!$game_loader->move(storage_path('app/loaders'), $cheat->loader_path)){
                array_push($response['message'],'Не удалось загрузить лоадер на сервер!');
                return json_encode($response);
            }
            $cheat->last_update = time();
        }

        if($game_dll){

            if(!$game_dll->move(storage_path('app/libs'), $cheat->dll_path)){
                array_push($response['message'],'Не удалось загрузить библиотеки на сервер!');
                return json_encode($response);
            }

            if(@$request['update-dll'])
                $cheat->last_update = time();
        }

        $cheat->save();
        $response['status'] = 'OK';
        return json_encode($response);
    }

    public function generatePromo(Request $request){
        $response = [
            'status' => 'ERROR',
            'message' => [],
            'promo_codes' => ''
        ];

        $messages = [
            'required' => 'Не все поля заполнены',
            'exists' => 'Данного чита не существует',
            'numeric' => 'Инкремент и кол-во должны быть числами',
        ];

        $validator = Validator::make($request->all(), [
            'cheat-id' => 'required|exists:cheats,id',
            'increment' => 'required|numeric',
            'count' => 'required|numeric',
        ], $messages);

        if($validator->fails()){
            $response['message'] = $validator->errors()->all();
            return json_encode($response);
        }

        $count = $request['count'];
        $seed = hash("sha256", openssl_random_pseudo_bytes(64).time());
        for($i = 0; $i < $count; $i++){
            $key = "{SHOCKBYTE@".time()."@".(rand(1, 999999999) - rand(1, 999999999))."@".openssl_random_pseudo_bytes(35)."@SHOCKBYTE}";
            $key = hash("md5", $key);
            $key = str_split($key, 8);
            $key = implode("-", $key);
            $key = strtoupper($key);

            $promo = new PromoCode();
            $promo->cheat_id = $request['cheat-id'];
            $promo->seed = $seed;
            $promo->promo = $key;
            $promo->increment = $request['increment'];
            $promo->save();

            $response['promo_codes'] .= "$promo->promo\r\n";
        }

        $response['status'] = 'OK';
        return json_encode($response);
    }
}
