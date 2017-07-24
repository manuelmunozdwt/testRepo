<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Comentario;

class ComentarioRepo 
{

	public function comentarios_por_validar(){
		return Comentario::where('confirmado', 0)->orderBy('created_at', 'DESC')->with('cupon')->paginate(15);
	}

	public function comentario($id){
		return Comentario::where('id',$id)->first();
	}

	public function get_comentarios_cupon($cupon){
		return Comentario::where('cupon_id', $cupon)->where('confirmado', 1)->with('usuario')->get();
	}

	public function get_comentario($user_id, $cupon_id){
		return Comentario::where('user_id', $user_id)->where('cupon_id', $cupon_id)->first();
	}

    public function comentarios_por_usuario($id_usuario)
    {
        return Comentario::where('user_id', $id_usuario)->paginate();
    }

    public function comentarios_por_cupon($id_cupon)
    {
        return Comentario::where('cupon_id', $id_cupon)->paginate();
    }
    
    public function crear_comentario($request) {

        return Comentario::create($request);
    }
    
    public function get_comentario_id($id){
		return Comentario::where('id', $id)->with('usuario')->first();
	}
}