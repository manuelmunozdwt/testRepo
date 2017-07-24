<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Role;
use App\Repositories\PermisoRepo;
use App\Repositories\RoleRepo;

class RolesController extends Controller
{
	public function __construct(PermisoRepo $permisoRepo,
                                RoleRepo $roleRepo)
	{
        $this->permisoRepo = $permisoRepo;
		$this->roleRepo = $roleRepo;
	}

    /**      
    * [index muestra la lista de roles con sus permisos correspondientes si el usuario logado tiene permiso para ello]     
    * @param  [tipo_variable] $nombre_variable [Que es la variable]      
    * @return view      
    */
    public function index(){
    	if(has_permiso('Ver lista permisos')){

    		$data['roles'] = $this->roleRepo->get_roles();

    		return view('permisos.roles', compact('data'));

    	}else{

            return view('errors.403');

        }
    }

    /**      
    * [create muestra el formulario de creación de nuevos roles si el usuario logado tiene permiso para ello]     
    * @param  [tipo_variable] $nombre_variable [Que es la variable]      
    * @return view      
    */
    public function create(){
        if(has_permiso('Crear permisos')){

            $data['permisos'] = $this->permisoRepo->get_permisos();

            return view('permisos.nuevo-rol', compact('data'));

        }else{

            return view('errors.403');
            
        }
    }

    /**      
    * [store guarda el nuevo rol con sus permiso asociados]    
    * @return view      
    */
    public function store(Request $request){
        $data['roles'] = $this->roleRepo->get_roles();

        $rol = New Role();
        $rol->nombre = $request->nombre;
        $rol->descripcion = $request->descripcion;
        $rol->save();

        if($request->permiso != null){            
            foreach($request->permiso as $rolpermiso){
                $rol->permiso()->attach($rolpermiso);
            }
        }

        return view('permisos.roles', compact('data'));

    }

    /**      
    * [show muestra un rol determinado con los permisos asignados, y puede modificarlos si el usuario logado tiene permiso para ello]     
    * @param  [integer] $id [id del rol]      
    * @return view      
    */
    public function show($id){
        if(has_permiso('Editar permisos')){

            $data['permisos'] = $this->permisoRepo->get_permisos();
            $data['rol'] = $this->roleRepo->get_rol($id);
            $data['array-permisos'] = ($data['rol']->permiso()->lists('permiso_id')->toArray());

            return view('permisos.rol', compact('data'));

        }else{

            return view('errors.403');
            
        }
    }


    public function edit($id){


    }

    /**      
    * [update actualiza los permisos de un rol determinado]     
    * @param  [integer] $id [id del rol]      
    * @return view      
    */
    public function update($id, Request $request){

    	$rol = $this->roleRepo->get_rol($id);

        if($rol->permiso()->first() != ''){  
            $permisos = $rol->permiso()->lists('permiso_id');
            foreach ($permisos as $permiso) {
                $rol->permiso()->detach($permiso);
            }      

        }
        if($request->permiso != null){            
            foreach($request->permiso as $rolpermiso){
                $rol->permiso()->attach($rolpermiso);
            }
        }

        return redirect()->back();
    }


    public function destroy(){

    }

}
