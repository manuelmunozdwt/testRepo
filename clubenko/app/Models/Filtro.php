<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filtro extends Model
{
	protected $table = 'filtros';
    //

    public function cupon(){
    	return $this->hasMany('App\Models\Cupon');
    }

}
