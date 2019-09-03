<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ApiRequest
 * @package App\Models
 * @property int id
 * @property int user_id
 * @property int cheat_id
 * @property string token
 * @property string ip
 */
class ApiRequest extends Model
{
    protected $table = 'api_requests';
}
