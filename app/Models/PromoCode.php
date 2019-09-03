<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PromoCode
 * @package App\Models
 * @property int id
 * @property int user_id
 * @property int cheat_id
 * @property string seed
 * @property string promo
 * @property int increment
 */
class PromoCode extends Model
{
    protected $table = 'promo_codes';
}
