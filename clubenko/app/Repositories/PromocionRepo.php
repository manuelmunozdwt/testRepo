<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Promocion;
use App\Models\Tienda;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class PromocionRepo
{
	//recoger todos los promociones confirmados y activos
    public function get_promociones(){
		return Promocion::where('confirmado', 1)		
			->where('fecha_inicio', '<=', Carbon::now()->toDateString())
			->where('fecha_fin', '>=', Carbon::now()->toDateString())
			->with('filtro','tienda')
			->orderBy('created_at','DESC')
			->get();
	}


    public static function total_promociones_activos(){
		return Promocion::where('confirmado', 1)		
			->where('fecha_inicio', '<=', Carbon::now()->toDateString())
			->where('fecha_fin', '>=', Carbon::now()->toDateString())
			->with('filtro','tienda')
			->orderBy('created_at','DESC')
			->get();
	}


	//sacamos los 4 promociones mas nuevos
    public static function get_promociones_activas_num($num_select_activos){
		return Promocion::where('confirmado', 1)		
			->where('fecha_inicio', '<=', Carbon::now()->toDateString())
			->where('fecha_fin', '>=', Carbon::now()->toDateString())
			->with('filtro','tienda')
			->orderBy('created_at','DESC')
			->take($num_select_activos)
			->get();
	}

	//Sacamos el promocion por ID siempre que esté publicado
	public function find_promocion_id_publicado($promocion_id)
	{
		return Promocion::where('confirmado', 1)
			->where('fecha_inicio', '<=', Carbon::now()->toDateString())
			->where('fecha_fin', '>=', Carbon::now()->toDateString())
			->where('id', $promocion_id)
			->with('categoria','subcategoria','filtro','tienda')
			->first();
	}


	//Scamos un promocion random. Se usa en la home para sacar una cupón aleatorio por defecto
	public function get_promocion_random_publicado()
	{
		return Promocion::where('confirmado', 1)		
			->where('fecha_inicio', '<=', Carbon::now()->toDateString())
			->where('fecha_fin', '>=', Carbon::now()->toDateString())
			->with('filtro','tienda')
			->inRandomOrder()
			->first();
	}


	public function get_promociones_whereIn($arr_promociones_provincia)
	{
		return Promocion::where('confirmado', 1)		
			->where('fecha_inicio', '<=', Carbon::now()->toDateString())
			->where('fecha_fin', '>=', Carbon::now()->toDateString())
			->whereIn('id',$arr_promociones_provincia)
			->with('filtro','tienda')
			->paginate(20);
	}


	//Sacamos un cupón publicado a partir de una fecha dada
	public function gete_promocion_publicado_a_apartir_fecha($fecha_publicacion)
	{
		return Promocion::where('confirmado', 1)		
			->where('fecha_inicio', '<=', Carbon::now()->toDateString())
			->where('fecha_fin', '>=', Carbon::now()->toDateString())
			->where('created_at', '>=', $fecha_publicacion)
			->with('filtro','tienda')
			->first();
	}

	//recoger todos los datos de un determinado promocion
	public function get_datos_promocion($slug){
		return Promocion::where('slug', $slug)->with('tienda','user')->first();
	}

	//recoger todos los promociones de una determinada categoría, confirmados y activos
	public function promociones_categoria($id){
		return Promocion::where('categoria_id', $id)
			->where('confirmado', 1)
			->where('fecha_inicio', '<=', Carbon::now()->toDateString())
			->where('fecha_fin', '>=', Carbon::now()->toDateString())
			->paginate(20);
	}

	//recoger todos los promociones de una determinada categoría, confirmados y activos
	public function promociones_subcategoria($id){
		return Promocion::where('subcategoria_id', $id)
			->where('confirmado', 1)
			->where('fecha_inicio', '<=', Carbon::now()->toDateString())
			->where('fecha_fin', '>=', Carbon::now()->toDateString())
			->paginate(20);
	}

	//recoger todos los promociones de una determinada categoría, confirmados y activos
	public function promociones_categoria_filtro($categoria_id, $filtro_id){
		return Promocion::where('categoria_id', $categoria_id)
			->where('filtro_id', $filtro_id)
			->where('confirmado', 1)
			->where('fecha_inicio', '<=', Carbon::now()->toDateString())
			->where('fecha_fin', '>=', Carbon::now()->toDateString())
			->paginate(20);

	}

	//recoger todos los promociones de una determinada tienda
    //Busca por objeto tienda
	public function promociones_tienda($tienda){

	   return $tienda->promocion()->where('confirmado', 1)
		    ->where(function ($query){
                $query->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                	  ->where('fecha_fin', '>=', Carbon::now()->toDateString());
            })->get();

	}

    //Busca por id tienda
    public function promociones_por_tienda($id_tienda)
    {
        return Promocion::join('promociones_tiendas', 'promociones.id', '=', 'promociones_tiendas.id_promocion')
            ->where('promociones_tiendas.id_tienda',$id_tienda)->paginate();
    }

	public function promociones_por_validar(){
		return Promocion::where('confirmado', 0)->paginate();
	}


	//recoger todos los promociones confirmados y activos
    public function mas_promociones_inicio(){
		return Promocion::where('confirmado', 1)		
			->where('fecha_inicio', '<=', Carbon::now()->toDateString())
			->where('fecha_fin', '>=', Carbon::now()->toDateString())
			->skip(3)
			->paginate(20);
	}


	//Total descaras cupón
    public function total_descargas($id){
		return Promocion::where('id', $id)->select('descargas')->first();
	}
	

	public function  buscador_promociones_inicio($categoria, $subcategoria, $comercio){
		if($comercio != ''){
			$comercio_id = User::findOrFail($comercio);
            return $comercio_id->promocion()->where('confirmado', 1)
            ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
            ->where('fecha_fin', '>=', Carbon::now()->toDateString())            
            ->get();
		}

		if($subcategoria == ''){		
			//Log::info(gettype(Carbon::now()->toDateString()));
			return Promocion::where('confirmado', 1)
				->where('categoria_id',  $categoria)
				->where('fecha_inicio', '<=', Carbon::now()->toDateString())
				->where('fecha_fin', '>=', Carbon::now()->toDateString())
				->get();
		}else{
			return Promocion::where('confirmado', 1)
				->where('categoria_id',  $categoria)
				->where('subcategoria_id',  $subcategoria)
				->where('fecha_inicio', '<=', Carbon::now()->toDateString())
				->where('fecha_fin', '>=', Carbon::now()->toDateString())
				->get();
		}
	}

	public function promociones_activos(){
		return Auth::user()->promocion()->where('confirmado', 1)
		->where('fecha_inicio', '<=', Carbon::now()->toDateString())
		->where('fecha_fin', '>=',  Carbon::now()->toDateString())
		->get();
	}

	public function promociones_caducados(){
		return Auth::user()->promocion()->where('confirmado', 1)
		->where('fecha_inicio', '<=', Carbon::now()->toDateString())
		->where('fecha_fin', '<',  Carbon::now()->toDateString())
		->get();
	}

	public function promociones_programados(){
		return Auth::user()->promocion()->where('confirmado', 1)
		->where('fecha_inicio', '>', Carbon::now()->toDateString())
		->get();
	}

	public function buscar($busqueda){
		return Auth::user()->promocion()->where('confirmado', 1)
		    ->where(function ($query) use ($busqueda) {
                $query->where('titulo', 'LIKE', '%' . $busqueda . '%')
                      ->orwhere('descripcion', 'LIKE', '%' . $busqueda . '%')
					  ->orwhere('descripcion_corta', 'LIKE', '%' . $busqueda . '%');
            })
			->where('fecha_inicio', '<', Carbon::now()->toDateString())
			->where('fecha_fin', '>', Carbon::now()->toDateString())
			->get();
	}

	public function buscar_caducados($busqueda){
		return Auth::user()->promocion()->where('confirmado', 1)
		    ->where(function ($query) use ($busqueda) {
                $query->where('titulo', 'LIKE', '%' . $busqueda . '%')
                      ->orwhere('descripcion', 'LIKE', '%' . $busqueda . '%')
					  ->orwhere('descripcion_corta', 'LIKE', '%' . $busqueda . '%');
            })
			->where('fecha_fin', '<', Carbon::now()->toDateString())
			->get();
	}

	public function buscar_programados($busqueda){
		return Auth::user()->promocion()->where('confirmado', 1)
		    ->where(function ($query) use ($busqueda) {
                $query->where('titulo', 'LIKE', '%' . $busqueda . '%')
                      ->orwhere('descripcion', 'LIKE', '%' . $busqueda . '%')
					  ->orwhere('descripcion_corta', 'LIKE', '%' . $busqueda . '%');
            })
			->where('fecha_inicio', '>', Carbon::now()->toDateString())
			->get();
	}


	public function crear_promocion($request){

		return Promocion::create($request);

	}

	public function aumentar_vista_promocion($promocion_id = null){
		return Promocion::where('id',$promocion_id)->increment('visitas');
	}



	public function get_random_nuevas_promociones($num_random, $num_seleccionados)
	{
			$promociones = Promocion::where('confirmado', 1)		
			->where('fecha_inicio', '<=', Carbon::now()->toDateString())
			->where('fecha_fin', '>=', Carbon::now()->toDateString())
			->with('filtro','tienda')
			->orderBy('created_at','DESC')
			->take($num_seleccionados)
			->get();

			$num_promocion = $promociones->count();

			if ($num_promocion > $num_random) {
				return $promociones->random($num_random);
			}
			elseif($num_promocion > 1){
				return $promociones->shuffle();
			}
			else{
				return $promociones;
			}
	}


	/**
	 * Sacamos las promociones más vistas
	 * @return [type] [description]
	 */
	public function get_promociones_mas_vistos()
	{
		return Promocion::where('confirmado', 1)		
			->where('fecha_inicio', '<=', Carbon::now()->toDateString())
			->where('fecha_fin', '>=', Carbon::now()->toDateString())
			->with('filtro','tienda')
			->orderBy('visitas','DESC')
			->get();
	}

	public function get_todas()
    {
        return Promocion::with('categoria','subcategoria','filtro')
            ->paginate();
    }

    public function get_promocion($id)
    {
        return Promocion::where('id', $id)
            ->with('categoria','subcategoria','filtro','user')
            ->first();
    }
    
    //Busca por id categoria
    public function promociones_por_categoria($id_categoria)
    {
        return Promocion::where('confirmado', 1)
                ->where('promociones.categoria_id',$id_categoria)->paginate();
    }
    
    //Busca por id subcategoria
    public function promociones_por_subcategoria($id_subcategoria)
    {
        return Promocion::where('confirmado', 1)
                ->where('subcategoria_id',$id_subcategoria)->paginate();
    }
    
    //obtener promocion borrada
    public function get_promocion_deleted($id)
    {
        return Promocion::where('id', $id)
            ->with('categoria','subcategoria','filtro')
            ->withTrashed()
            ->first();
    }
}
