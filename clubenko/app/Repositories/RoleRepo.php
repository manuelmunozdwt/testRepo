<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Role;

class RoleRepo
{

	public function get_roles(){
		return Role::all();
	}
	public function get_rol($id){
		return Role::where('id', $id)->first();
	}

}
