<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Categoria;
use Carbon\Carbon;

use DB;

class CategoriaRepo 
{
	public function categorias_por_validar(){
		return Categoria::where('confirmado', 0)->orderBy('created_at', 'DESC')->get();
	}

	public static function get_categorias(){
		return Categoria::where('confirmado', 1)->with('cupon','cupones_activos')->get();
	}

	public function datos_categoria($slug){
		return Categoria::where('slug', $slug)->with('cupon','cupones_activos')->first();
	}
	
	public function get_categoria_id($id){
		return Categoria::where('id', $id)->where('confirmado', 1)->first();
	}


	/**
	 * Sacamos las categorías más populares
	 * @return [type] [description]
	 */
	public function categorias_populares($num_categorias_populares)
	{
		return Categoria::select(DB::raw('categorias.*, count(*) as `aggregate`'))
	    ->join('cupones', 'categorias.id', '=', 'cupones.categoria_id')
	    ->groupBy('categoria_id')
	    ->where('cupones.confirmado', 1)		
		->where('fecha_inicio', '<=', Carbon::now()->toDateString())
		->where('fecha_fin', '>=', Carbon::now()->toDateString())
	    ->orderBy('aggregate', 'desc')
	    ->with('cupon','cupones_activos')
	    ->take($num_categorias_populares)
	    ->get();
	}
}