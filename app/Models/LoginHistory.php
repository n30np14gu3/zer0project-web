<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoginHistory
 * @package App\Models
 * @property int id
 * @property int user_id
 * @property string ip
 */
class LoginHistory extends Model
{
    protected $table = 'login_history';
}
