<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permisos';

    public function role(){
    	return $this->belongsToMany('App\Models\Role', 'permisos_roles', 'permiso_id', 'rol_id');
    }

    public function user(){
    	return $this->belongsToMany('App\Models\User', 'permisos_user', 'permiso_id', 'user_id');
    }
}
