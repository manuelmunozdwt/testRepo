<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Tienda extends Model
{
	use SoftDeletes;

    protected $fillable = array('nombre', 'logo', 'slug', 'direccion', 'provincia_id', 'telefono', 'web', 'latitud', 'longitud', 'confirmado');

	protected $table = 'tiendas';

    //Relación many to many con usuarios
    public function usuario(){
        return $this->belongsToMany('App\Models\User', 'usuarios_tiendas', 'id_tienda', 'id_usuario');
    }
    
	public function cupon(){
        return $this->belongsToMany('App\Models\Cupon', 'cupones_tiendas', 'id_tienda', 'id_cupon');
    }

    public function promocion(){
        return $this->belongsToMany('App\Models\Promocion', 'promociones_tiendas', 'id_tienda', 'id_promocion');
    }

    public function cupones_activos(){
        return $this->belongsToMany('App\Models\Cupon', 'cupones_tiendas', 'id_tienda', 'id_cupon')->where('confirmado', 1)       
							                                                                ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
							                                                                ->where('fecha_fin', '>=', Carbon::now()->toDateString())
							                                                                ->with('filtro');
	}

    public function provincia(){
        return $this->belongsTo('App\Models\Provincias','provincia_id','id');
    }
    
    public function getImagenAbsolutoAttribute()
    {
        $host = request()->server('REQUEST_SCHEME');
        $host .= '://' . request()->server('HTTP_HOST');
        $imagenPath = $host .'/'. $this->logo;
        return $imagenPath;
    }
}   

