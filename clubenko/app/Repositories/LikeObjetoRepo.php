<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\LikeObjeto;

class LikeObjetoRepo
{

	public function comprobarLike($objeto_id, $id_tipo_objeto,$user_id)
    {
        return LikeObjeto::where('objeto', $objeto_id)->where('user_id', $user_id)->where('tipo_id', $id_tipo_objeto)->get();
    }

    public function contarLike($objeto_id, $id_tipo_objeto)
    {
        return LikeObjeto::where('objeto', $objeto_id)->where('tipo_id', $id_tipo_objeto)->get();
    }

    public function borrarLike($objeto_id, $id_tipo_objeto, $user_id)
    {
       return LikeObjeto::where('objeto', $objeto_id)->where('user_id', $user_id)->where('tipo_id', $id_tipo_objeto)->delete();
    }


}