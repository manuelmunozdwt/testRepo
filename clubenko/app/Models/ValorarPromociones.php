<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValorarPromociones extends Model
{
    protected $table = 'valoraciones_promociones';
    protected $fillable = ['user_id','promocion_id','valoracion'];

}
