<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikeObjeto extends Model
{
	protected $table = 'like_objeto';
    //

    public function cupon(){
    	return $this->hasMany('App\Models\Cupon');
    }

}