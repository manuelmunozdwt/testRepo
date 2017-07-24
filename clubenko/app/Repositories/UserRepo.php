<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class UserRepo
{
	
	public function todos_los_usuarios(){
		return User::get();
	}

	public function get_mis_datos($slug){

		return  User::where('slug', $slug)->first();
	}

	public function get_usuarios_por_validar(){
		return User::where('confirmado', '0')->orderBy('created_at', 'DESC')->get();
	}

	public function usuario($id){
		return User::where('id',$id)->first();
	}

	public function get_comercios(){
		return User::where('rol', 2)->get();
	}

    public function get_todos()
    {
        return User::paginate();
    }
    
    //obtener promocion borrada
    public function get_user_deleted($id)
    {
        return User::where('id', $id)
            ->withTrashed()
            ->first();
    }

    public function crear_usuario($request)
    {
		return User::create($request);
	}

}