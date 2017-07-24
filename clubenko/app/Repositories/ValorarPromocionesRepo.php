<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\ValorarPromociones;

class ValorarPromocionesRepo
{

	public function insert($datos_nuevos = null){
		return ValorarPromociones::insert($datos_nuevos);
	}
	
	/**
	 * [get_valoraciones_cupon obtenemos un array de las valoraciones de un cupon]
	 * @param  [int] $promocion_id [ID del cupon]
	 * @return [array]           [array con el valor de cada valoracion]
	 */
	public function get_valoracion_user($promocion_id = null){
		if(!auth()->check()){
			return null;
		}
		return ValorarPromociones::where('promocion_id',$promocion_id)->where('user_id',auth()->user()->id)->first();
	}


}