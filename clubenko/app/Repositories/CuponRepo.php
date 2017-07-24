<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cupon;
use App\Models\Tienda;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class CuponRepo {

    //recoger todos los cupones confirmados y activos
    public function get_cupones() {
        return Cupon::where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->with('filtro', 'tienda')
                        ->orderBy('created_at', 'DESC')
                        ->get();
    }

    public static function total_cupones_activos() {
        return Cupon::where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->with('filtro', 'tienda')
                        ->orderBy('created_at', 'DESC')
                        ->get();
    }

    public static function get_cupones_activos_num($num_select_activos) {
        return Cupon::where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->with('filtro', 'tienda')
                        ->orderBy('created_at', 'DESC')
                        ->take($num_select_activos)
                        ->get();
    }

    //Sacamos el cupon por ID siempre que esté publicado
    public function find_cupon_id_publicado($cupon_id) {
        return Cupon::where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->where('id', $cupon_id)
                        ->with('filtro', 'tienda')
                        ->first();
    }

    //Scamos un cupon random. Se usa en la home para sacar una cupón aleatorio por defecto
    public function get_cupon_random_publicado() {
        return Cupon::where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->with('filtro', 'tienda')
                        ->inRandomOrder()
                        ->first();
    }

    public function get_cupones_whereIn($arr_cupones_provincia) {
        return Cupon::where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->whereIn('id', $arr_cupones_provincia)
                        ->with('filtro', 'tienda')
                        ->paginate(20);
    }

    //Sacamos un cupón publicado a partir de una fecha dada
    public function gete_cupon_publicado_a_apartir_fecha($fecha_publicacion) {
        return Cupon::where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->where('created_at', '>=', $fecha_publicacion)
                        ->with('filtro', 'tienda')
                        ->first();
    }

    //recoger todos los datos de un determinado cupon
    public function get_datos_cupon($slug) {
        return Cupon::where('slug', $slug)->with('tienda', 'user')->first();
    }

    //recoger todos los cupones de una determinada categoría, confirmados y activos
    public function cupones_categoria($id) {
        return Cupon::where('categoria_id', $id)
                        ->where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->paginate(20);
    }

    //recoger todos los cupones de una determinada categoría, confirmados y activos
    public function cupones_subcategoria($id) {
        return Cupon::where('subcategoria_id', $id)
                        ->where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->paginate(20);
    }

    //recoger todos los cupones de una determinada categoría, confirmados y activos
    public function cupones_categoria_filtro($categoria_id, $filtro_id) {
        return Cupon::where('categoria_id', $categoria_id)
                        ->where('filtro_id', $filtro_id)
                        ->where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->paginate(20);
    }

    //recoger todos los cupones de una determinada tienda
    //Busca por objeto tienda
    public function cupones_tienda($tienda) {

        return $tienda->cupon()->where('confirmado', 1)
                        ->where(function ($query) {
                            $query->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                            ->where('fecha_fin', '>=', Carbon::now()->toDateString());
                        })->get();
    }

    //Busca por id tienda
    public function cupones_por_tienda($id_tienda)
    {
        return Cupon::join('cupones_tiendas', 'cupones.id', '=', 'cupones_tiendas.id_cupon')
            ->where('cupones_tiendas.id_tienda',$id_tienda)->paginate();
    }

    public function cupones_por_validar() {
        return Cupon::where('confirmado', 0)->orderBy('created_at', 'DESC')->paginate();
    }

    //recoger todos los cupones confirmados y activos
    public function mas_cupones_inicio() {
        return Cupon::where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->skip(3)
                        ->paginate(20);
    }

    //Total descaras cupón
    public function total_descargas($id) {
        return Cupon::where('id', $id)->select('descargas')->first();
    }

    public function buscador_cupones_inicio($categoria, $subcategoria, $comercio) {
        if ($comercio != '') {
            $comercio_id = User::findOrFail($comercio);
            return $comercio_id->cupon()->where('confirmado', 1)
                            ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                            ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                            ->get();
        }

        if ($subcategoria == '') {
            //Log::info(gettype(Carbon::now()->toDateString()));
            return Cupon::where('confirmado', 1)
                            ->where('categoria_id', $categoria)
                            ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                            ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                            ->get();
        } else {
            return Cupon::where('confirmado', 1)
                            ->where('categoria_id', $categoria)
                            ->where('subcategoria_id', $subcategoria)
                            ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                            ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                            ->get();
        }
    }

    public function cupones_activos() {
        return Auth::user()->cupon()->where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->get();
    }

    public function cupones_caducados() {
        return Auth::user()->cupon()->where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '<', Carbon::now()->toDateString())
                        ->get();
    }

    public function cupones_programados() {
        return Auth::user()->cupon()->where('confirmado', 1)
                        ->where('fecha_inicio', '>', Carbon::now()->toDateString())
                        ->get();
    }

    public function buscar($busqueda) {
        return Auth::user()->cupon()->where('confirmado', 1)
                        ->where(function ($query) use ($busqueda) {
                            $query->where('titulo', 'LIKE', '%' . $busqueda . '%')
                            ->orwhere('descripcion', 'LIKE', '%' . $busqueda . '%')
                            ->orwhere('descripcion_corta', 'LIKE', '%' . $busqueda . '%');
                        })
                        ->where('fecha_inicio', '<', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>', Carbon::now()->toDateString())
                        ->get();
    }

    public function buscar_caducados($busqueda) {
        return Auth::user()->cupon()->where('confirmado', 1)
                        ->where(function ($query) use ($busqueda) {
                            $query->where('titulo', 'LIKE', '%' . $busqueda . '%')
                            ->orwhere('descripcion', 'LIKE', '%' . $busqueda . '%')
                            ->orwhere('descripcion_corta', 'LIKE', '%' . $busqueda . '%');
                        })
                        ->where('fecha_fin', '<', Carbon::now()->toDateString())
                        ->get();
    }

    public function buscar_programados($busqueda) {
        return Auth::user()->cupon()->where('confirmado', 1)
                        ->where(function ($query) use ($busqueda) {
                            $query->where('titulo', 'LIKE', '%' . $busqueda . '%')
                            ->orwhere('descripcion', 'LIKE', '%' . $busqueda . '%')
                            ->orwhere('descripcion_corta', 'LIKE', '%' . $busqueda . '%');
                        })
                        ->where('fecha_inicio', '>', Carbon::now()->toDateString())
                        ->get();
    }

    public function crear_cupon($request) {

        return Cupon::create($request);
    }

    public function get_four_ramdom_cupon() {
        return Cupon::where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->with('filtro', 'tienda')
                        ->orderBy('created_at', 'DESC')
                        ->get()
                        ->random(4);
    }

    public function aumentar_vista_cupon($cupon_id = null) {
        return Cupon::where('id', $cupon_id)->increment('visitas');
    }

    public function get_random_nuevos_cupones($num_random, $num_seleccionados) {
        $cupones = Cupon::where('confirmado', 1)
                ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                ->with('filtro', 'tienda')
                ->orderBy('created_at', 'DESC')
                ->take($num_seleccionados)
                ->get();

        $num_cupones = $cupones->count();

        if ($num_cupones > $num_random) {
            return $cupones->random($num_random);
        } elseif ($num_cupones > 1) {
            return $cupones->shuffle();
        } else {
            return $cupones;
        }
    }

    /**
     * Sacamos los cupones más vistos
     * @return [type] [description]
     */
    public function get_cupones_mas_vistos() {
        return Cupon::where('confirmado', 1)
                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                        ->with('filtro', 'tienda')
                        ->orderBy('visitas', 'DESC')
                        ->get();
    }

    public function get_todas() {
        return Cupon::with('categoria', 'subcategoria', 'filtro')
                        ->paginate();
    }
    
    public function get_cupon($id)
    {
        return Cupon::where('id', $id)
            ->with('categoria','subcategoria','filtro')
            ->first();
    }
    
    //Busca por id categoria
    public function cupones_por_categoria($id_categoria)
    {
        return Cupon::where('confirmado', 1)
                ->where('categoria_id',$id_categoria)->paginate();
    }
    
    //Busca por id subcategoria
    public function cupones_por_subcategoria($id_subcategoria)
    {
        return Cupon::where('confirmado', 1)
                ->where('subcategoria_id',$id_subcategoria)->paginate();
    }
    
    //obtener cupon borrado
    public function get_cupon_deleted($id)
    {
        return Cupon::where('id', $id)
            ->with('categoria','subcategoria','filtro')
            ->withTrashed()
            ->first();
    }

}
