<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Cupon extends Model
{
	use SoftDeletes;

	protected $table = 'cupones';

    protected $casts = [
        'dime_tus_tiendas' => 'string',
    ];

    protected $fillable = array('titulo','descripcion','descripcion_corta','condiciones','imagen','logo','slug','codigo','fecha_inicio','fecha_fin','confirmado','descargas','categoria_id','subcategoria_id','filtro_id','visitas','valoracion');

    public function tienda(){
    	return $this->belongsToMany('App\Models\Tienda', 'cupones_tiendas', 'id_cupon', 'id_tienda');
    }

    public function categoria(){
    	return $this->belongsTo('App\Models\Categoria', 'categoria_id');
    }

    public function subcategoria(){
    	return $this->belongsTo('App\Models\Subcategoria', 'subcategoria_id');
    }

    public function filtro(){
    	return $this->belongsTo('App\Models\Filtro', 'filtro_id');
    }

    public function user(){
        return $this->belongsToMany('App\Models\User', 'cupones_user', 'cupon_id', 'user_id');
    }

    public function descargas_user(){
        return $this->belongsToMany('App\Models\User', 'cupones_descargas_user', 'cupon_id', 'user_id')->withTimestamps();
    }

    public function comentario(){
        return $this->hasMany('App\Models\Comentario');
    }

    public function bloque(){
        return $this->hasOne('App\Models\Bloque');
    }


    public function get_dime_tus_tiendas()
    {
        if ($this['tienda']->count() > 1)
            return $this->dime_tus_tiendas = 'Varias tiendas';

        elseif(isset($this['tienda'][0]))
            return $this['tienda'][0]->direccion;

        else
            return '';
      
    }


    public function getURLattribute()
    {
        return $this->url = route('home_ver_cupon',$this->slug);
    }


    public function getImagenUrlattribute()
    {
        return $this->imagen_url = asset('img/cupones') . '/' . $this->imagen;
    }
}
