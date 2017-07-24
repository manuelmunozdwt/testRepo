<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentarios';
    
    protected $fillable = array('comentario','cupon_id','user_id');

    public function usuario(){

    	return $this->belongsTo('App\Models\User', 'user_id');

    }

    public function cupon(){

    	return $this->belongsTo('App\Models\Cupon', 'cupon_id');
    }
}
