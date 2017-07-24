<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Bloque;

class BloqueRepo 
{

	public function get_all_bloques(){
		return Bloque::get();
	}
	
	public function get_datos_bloque($id){
		return Bloque::where('id', $id)->first();
	}

	public function get_populares(){
		return Bloque::where('tipo', 'populares')->get();
	}

    public function get_bloques(){
    	return Bloque::where('tipo', 'bloque')->get();
    }

    /**
     * Sacamos el cupon de la home pública desktop. este cupón es el destacado
     * @return [type] [description]
     */
    public function get_desktop_cupon_principal_home(){
    	return Bloque::where('tipo', 'desktop_cupon_principal')->first();
    }


}