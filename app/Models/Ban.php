<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ban
 * @package App\Models
 * @property int id
 * @property int user_id
 * @property string reason
 * @property bool is_lifetime
 * @property int end_date
 * @property int active
 *
 */
class Ban extends Model
{

}
