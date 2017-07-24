<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Subcategoria;

class SubcategoriaRepo 
{
	public function get_subcategorias(){
		return Subcategoria::where('confirmado', '1')->get();
	}

	public function subcategorias_por_validar(){
		return Subcategoria::where('confirmado', '0')->orderBy('created_at', 'DESC')->get();
	}

	public function datos_subcategoria($slug){
		return Subcategoria::where('slug', $slug)->first();
	}

	public function get_datos_subcategoria($cat_id, $subcat){
		return Subcategoria::where('categoria_id', $cat_id)
							->where('slug', $subcat)->first();
	}
	public function get_subcategoria_id($id){
		return Subcategoria::where('id', $id )->where('confirmado', '1')->first();
	}
}