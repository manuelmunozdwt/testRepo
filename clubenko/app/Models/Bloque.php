<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloque extends Model
{
    protected $table = "bloques_inicio";

    public function cupon(){
    	return $this->belongsTo('App\Models\Cupon');
    }
}
