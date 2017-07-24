<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Categoria extends Model
{
	use SoftDeletes;

    protected $table = 'categorias';

    public function cupones_activos(){
        return $this->hasMany('App\Models\Cupon', 'categoria_id')->where('confirmado', 1)       
                                                                ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                                                                ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                                                                ->with('tienda','filtro');
    }

    public function promociones_activos(){

        return $this->hasMany('App\Models\Promocion', 'categoria_id')->where('confirmado', 1)       
                                                                ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                                                                ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                                                                ->with('tienda','filtro');
    }


    public function getActivosAttribute(){

        return $this->cupones_activos->count() + $this->promociones_activos->count();

    }

    public function cupones_activos_paginado($num_paginacion = 15){
        return $this->hasMany('App\Models\Cupon', 'categoria_id')->where('confirmado', 1)       
                                                                ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                                                                ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                                                                ->with('tienda','filtro')
                                                                ->get();
    }

    public function promociones_activos_paginado($num_paginacion = 15){
        return $this->hasMany('App\Models\Promocion', 'categoria_id')->where('confirmado', 1)       
                                                                ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                                                                ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                                                                ->with('tienda','filtro')
                                                                ->get();
    }

    public function cupon(){
    	return $this->hasMany('App\Models\Cupon', 'categoria_id');
    }

    public function subcategoria(){
    	return $this->hasMany('App\Models\Subcategoria', 'categoria_id');
    }

}
