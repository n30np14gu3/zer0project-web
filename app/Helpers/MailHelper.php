<?php


namespace App\Helpers;


use App\Models\EmailConfirm;

class MailHelper
{
    /**
     * @param int $user_id
     * @return string
     */
    public static function GenerateConfirmToken($user_id){
        $confirm = new EmailConfirm();
        $confirm->ip = @$_SERVER['REMOTE_ADDR'];
        $confirm->user_id = $user_id;
        $confirm->visited = 0;
        $confirm->token = hash("sha256", openssl_random_pseudo_bytes(64).time());
        $confirm->save();

        return $confirm->token;
    }
}
