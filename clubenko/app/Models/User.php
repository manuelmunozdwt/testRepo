<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Carbon\Carbon;

class User extends Authenticatable
{
     use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','nombre','dni','password','apellidos','email','slug','imagen','confirmado','rol','nombre_comercio','sobre_comercio','web_comercio'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //relación one to many con roles (1 rol puede tener varios usuarios)
    public function role(){
        return $this->belongsTo('App\Models\Role', 'rol');
    }

    public function permiso(){
        return $this->belongsToMany('App\Models\Permiso', 'permisos_user', 'user_id', 'permiso_id');
    }
    //relación many to may con tiendas
    public function tienda(){
        return $this->belongsToMany('App\Models\Tienda', 'usuarios_tiendas', 'id_usuario', 'id_tienda');
    }

    public function cupon(){
        return $this->belongsToMany('App\Models\Cupon', 'cupones_user', 'user_id', 'cupon_id');
    }

    public function cupones_activos(){
        return $this->hasMany('App\Models\Cupon', 'cupones_user', 'user_id', 'cupon_id')->where('confirmado', 1)       
                                                                                        ->where('fecha_inicio', '<=', Carbon::now()->toDateString())
                                                                                        ->where('fecha_fin', '>=', Carbon::now()->toDateString())
                                                                                        ->with('tienda','filtro');
    }

    public function comentario(){
        return $This->hasMany('App\Models\Comentario');
    }

    public function getNombreCompletoAttribute()
    {
        return $this->name . ' ' . $this->apellidos;
    }

    public function promocion(){
        return $this->belongsToMany('App\Models\Promocion', 'promociones_user', 'user_id', 'promocion_id');
    }
    
    public function getImagenAbsolutoAttribute()
    {
        $host = request()->server('REQUEST_SCHEME');
        $host .= '://' . request()->server('HTTP_HOST');
        $imagenPath = $host . $this->imagen;
        return $imagenPath;
    }
    
    

    
}
