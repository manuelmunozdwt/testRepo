<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Subcategoria extends Model
{
    protected $table = 'subcategorias';

	use SoftDeletes;


    public function categoria(){
    	return $this->belongsTo('App\Models\Categoria');
    }


    public function cupones_activos(){
        return $this->hasMany('App\Models\Cupon', 'subcategoria_id')->where('confirmado', 1)       
                                                                ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                                                                ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                                                                ->with('tienda','filtro');
    }

    public function cupones_activos_paginado($num_paginacion = 15){
        return $this->hasMany('App\Models\Cupon', 'subcategoria_id')->where('confirmado', 1)       
                                                                ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                                                                ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                                                                ->with('tienda','filtro')
                                                                ->paginate($num_paginacion);
    }
}
