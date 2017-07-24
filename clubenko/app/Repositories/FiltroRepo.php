<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Filtro;

class FiltroRepo
{
	//recoger todos los cupones
    public function get_filtros(){
		return Filtro::get();
	}


	public function datos_filtro($id){
		return Filtro::where('id', $id)->first();
	}

	//Sacamos el nombre del filtro
	public function nombre_filtro($id){
		return Filtro::where('id', $id)->select('nombre')->get();
	}


}
