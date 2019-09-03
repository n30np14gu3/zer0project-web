<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailConfirm
 * @package App\Models
 * @property int id
 * @property int user_id
 * @property string token
 * @property boolean visited
 * @property string ip
 */
class EmailConfirm extends Model
{
    protected $table = 'email_confirms';
}
