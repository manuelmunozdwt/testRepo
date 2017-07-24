<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Repositories\PermisoRepo;
use App\Repositories\RoleRepo;

class PermisosController extends Controller
{
	public function __construct(PermisoRepo $permisoRepo,
                                RoleRepo $roleRepo)
	{
        $this->permisoRepo = $permisoRepo;
		$this->roleRepo = $roleRepo;
	}

    public function index(){
    	if(has_permiso('Ver lista permisos')){

    		$data['roles'] = $this->roleRepo->get_roles();

    		return view('permisos.roles', compact('data'));

    	}else{

            return view('errors.403');

        }
    }


    public function create(){
        if(has_permiso('Crear permisos')){

            $data['permisos'] = $this->PermisoRepo->get_permisos();

            return view('permisos.nuevo-permiso', compact('data'));

        }else{

            return view('errors.403');
            
        }
    }


    public function arr_permisos_usuario($user = null)
    {
        if (is_null($user)) {
            return null;
        }

        $array_permisos_user = ($user->permiso()->lists('permiso_id')->toArray());

        $array_permisos_rol = ($user->role->permiso->lists('id')->toArray());

        $permisos_denegados = ($user->permiso()->where('permitido', 0)->lists('permiso_id')->toArray());

        return array_diff(array_merge( $array_permisos_user, $array_permisos_rol), $permisos_denegados);
    }


    public function store(){

    }


    public function show(){

    }


    public function edit(){

    }


    public function update(){


    }


    public function destroy(){

    }

}
