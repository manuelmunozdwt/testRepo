<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Permiso;

class PermisoRepo
{

    public function user_can($action){
		return Permiso::where('nombre', $action);
	}

	public function get_permisos(){
		return Permiso::all();
	}

	/*public function get_permisos_rol($rol){
		return Permiso::with(['role' => function ($query) {
		    $query->where('rol_id', 2);
		}])->get();
	}*/

}
