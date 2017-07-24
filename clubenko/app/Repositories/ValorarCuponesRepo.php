<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\ValorarCupones;

class ValorarCuponesRepo
{

	public function insert($datos_nuevos = null){
		return ValorarCupones::insert($datos_nuevos);
	}
	
	/**
	 * [get_valoraciones_cupon obtenemos un array de las valoraciones de un cupon]
	 * @param  [int] $cupon_id [ID del cupon]
	 * @return [array]           [array con el valor de cada valoracion]
	 */
	public function get_valoracion_user($cupon_id = null){
		if(!auth()->check()){
			return null;
		}
		return ValorarCupones::where('cupon_id',$cupon_id)->where('user_id',auth()->user()->id)->first();
	}


}