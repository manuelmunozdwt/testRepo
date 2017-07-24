<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Tienda;

class TiendaRepo
{
	public function get_tiendas(){
		return Tienda::get();
	}

	public function datos_tienda($slug){

		return  Tienda::where('slug', $slug)->first();
	}

	public function get_todas_tiendas_validadas(){
		return Tienda::where('confirmado', 1)->with('cupon','cupones_activos')->get();
	}

	public function tiendas_por_validar(){
		return Tienda::where('confirmado', 0)->orderBy('created_at', 'DESC')->get();
	}

	public function tiendas_por_provincia($provincia_id)
	{
		return Tienda::where('confirmado', 1)->where('provincia_id', $provincia_id)->with('cupon','cupones_activos')->get();
	}

	public function get_todas()
    {
        return Tienda::with('provincia')->paginate();
    }

    public function get_tienda($id)
    {
        return Tienda::where('id', $id)->with('provincia')->first();
    }

    public function crear_tienda($request)
    {
        return Tienda::create($request);
    }

    public function tiendas_por_comercio($id_comercio)
    {
        return Tienda::join('usuarios_tiendas', 'tiendas.id', '=', 'usuarios_tiendas.id_tienda')
                    ->where('usuarios_tiendas.id_usuario',$id_comercio)->paginate();
    }
    
    public function tiendas_provincia($id_provincia)
    {
        return Tienda::where('confirmado', 1)->where('tiendas.provincia_id',$id_provincia)->paginate();
    }
    
    //obtener tienda borrada
    public function get_tienda_deleted($id)
    {
        return Tienda::where('id', $id)
            ->with('provincia')
            ->withTrashed()
            ->first();
    }
}