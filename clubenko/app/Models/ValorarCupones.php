<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValorarCupones extends Model
{
    protected $table = 'valoraciones_cupones';
    protected $fillable = ['user_id','cupon_id','valoracion'];

}
