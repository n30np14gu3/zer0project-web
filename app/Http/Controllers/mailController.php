<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Helpers\UserHelper;
use App\Mail\CompleteRegister;
use App\Models\EmailConfirm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class mailController extends Controller
{
    public function confirm(Request $request, $token){
        $data = [
            'style' => 'alert-danger',
            'content' => ''
        ];

        $confirm = @EmailConfirm::where('token', $token)->get()->first();
        if(!$confirm){
            $data['content'] = 'Ссылка недействительна!';
            goto go_view;
        }

        $user = UserHelper::GetUser($request);
        if(@$user->id != $confirm->user_id && $user != null){
            $data['content'] = 'Ссылка принадлежит другому пользователю!';
            goto go_view;
        }

        if($confirm->ip != @$_SERVER['REMOTE_ADDR']){
            $data['content'] = 'Ссылка привязана к другому IP!';
            goto go_view;
        }

        if($user == null)
            $user = User::where('id', $confirm->user_id)->get()->first();

        if(time() - strtotime($confirm->created_at) > 60*60*24){
            $data['content'] = 'Ссылка устарела! На почтовый ящик была отправлена новая ссылка';
            Mail::to($user->email)->send(
                new CompleteRegister(
                    MailHelper::GenerateConfirmToken($user->id),
                    'Подтверждение регистрации',
                    'Регистрация на '.env('CHEAT_NAME')));
            goto go_view;
        }

        if($confirm->visited){
            $data['content'] = 'Ссылка уже была посещена!';
            goto go_view;
        }

        if($user->status != 0){
            $data['content'] = 'Пользователь уже подтвердил свой аккаунт!';
            goto go_view;
        }

        $confirm->visited = 1;
        $confirm->save();

        $user->status = 1;
        $user->save();

        $data['style'] = 'alert-success';
        $data['content'] = 'Пользователь успешно подтверджен';

        go_view:
        return view('pages.message')->with(['data' => $data, 'logged' => UserHelper::CheckAuth($request)]);
    }
}
