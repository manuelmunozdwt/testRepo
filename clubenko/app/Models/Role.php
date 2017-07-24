<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

 	protected $table = 'roles';

 	//relación one to many con usuarios (1 usuario solo tiene 1 rol)
    public function usuario(){
        return $this->hasMany('App\Models\User');
    }

    public function permiso(){
    	return $this->belongsToMany('App\Models\Permiso', 'permisos_roles', 'rol_id', 'permiso_id');
    }
}
