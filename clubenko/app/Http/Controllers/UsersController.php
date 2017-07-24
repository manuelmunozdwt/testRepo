<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
    use App\Http\Requests;
	use App\Http\Requests\UserRequest;

    use Validator;
    use App\Models\User;

    use App\Http\Controllers\PermisosController;
    use App\Repositories\UserRepo;
    use App\Repositories\TiendaRepo;
    use App\Repositories\PermisoRepo;
	use App\Repositories\RoleRepo;
    use Auth;

    use DB;
    use BrowserDetect;



class UsersController extends Controller{


    public function __construct(UserRepo $userRepo,
                                TiendaRepo $tiendaRepo,
                                PermisoRepo $permisoRepo,
                                RoleRepo $roleRepo,
                                PermisosController $permisosController)
    {
        $this->userRepo = $userRepo;
        $this->tiendaRepo = $tiendaRepo;
        $this->permisoRepo = $permisoRepo;
        $this->roleRepo = $roleRepo;
        $this->permisosController = $permisosController;
    }

    public function index(){
        if(!has_permiso('Validar usuarios')){
            return view('errors.403');
        }

        $data['usuarios'] = $this->userRepo->get_usuarios_por_validar();

        return view('dashboard.validaciones.lista-usuarios', compact('data'));

    }

    /**
     * muestra los datos del usuario
     * @param  string $slug slug del usuario
     * @return response
     */    
    public function show($slug){
        if(!has_permiso('Ver detalle usuarios')){
            return view('errors.403');
        }

        $data['permisos'] = $this->permisoRepo->get_permisos();
        $data['mis-datos'] = $this->userRepo->get_mis_datos($slug);

        $data['array-permisos'] = $this->permisosController->arr_permisos_usuario($data['mis-datos']);

        if(Auth::user()->rol == 2 && BrowserDetect::isDesktop())
        {
            return view('dashboard.gestion.perfil', compact('data'));
        }

        return return_vistas('users.show', $data);
            
    } 


    public function mis_datos()
    {

        $data['permisos'] = $this->permisoRepo->get_permisos();
        $data['mis-datos'] = Auth::user();

        if (has_permiso('Ver lista permisos')) {
            $data['array-permisos'] = $this->permisosController->arr_permisos_usuario($data['mis-datos']);
        }

        /*if(Auth::user()->rol != 2 && BrowserDetect::isDesktop())
        {
            return view('dashboard.gestion.perfil', compact('data'));
        }*/

        return return_vistas('users.show', $data);
    }   


    /**
     * Muestra la vista de edición del usuario
     * @param  [type] [description]
     * @return [type] [description]
     */
    public function edit($slug){

        if(!has_permiso('Editar usuarios')){
            return view('errors.403');
        }

        $data['permisos'] = $this->permisoRepo->get_permisos();
        $data['mis-datos'] = $this->userRepo->get_mis_datos($slug);

        $data['array-permisos'] = $this->permisosController->arr_permisos_usuario($data['mis-datos']);
        
        $data['roles'] = $this->roleRepo->get_roles();

        return view('users.edit', compact('data'));
            
    }

    /**
     * Almacena los nuevos datos del usuario
     * @param  [type] [description]
     * @return [type] [description]
     */
    public function update($slug, UserRequest $request){
        
        $user = $this->userRepo->get_mis_datos($slug);

    	$user->name = $request->nombre;

        $user->apellidos = $request->apellidos;

        $user->nombre_comercio = $request->nombre_comercio;

        $user->email = $request->email;
        if($request->password != ''){
            $user->password = bcrypt($request->password);
        }

        if($user->rol != 1){
            //en caso de un rol Comercio guardamos su descripcion
            $user->sobre_comercio = $request->sobre_comercio;

            //verificamos si la web del comercio lleva el http, sino se lo concatenamos
            if(strpos($request->web_comercio, 'http') === false){
                $user->web_comercio = 'https://'.$request->web_comercio;
            }else{
                $user->web_comercio = $request->web_comercio;
            }
        }

        $user->imagen = subir_imagen('logo',$request->logo, $user->id, 'usuarios');

        $user->save();

        if(Auth::user()->rol == 3 && BrowserDetect::isDesktop()){

    	   $user->rol = $request->rol;
       
            if($user->permiso()->first() != ''){  
                $permisos = $user->permiso()->lists('permiso_id');
                foreach ($permisos as $permiso) {
                    $user->permiso()->detach($permiso);
                }      
            }

        }
    
        if($user->save()){
            $errors="Sus cambios han sido realizados con éxito";
        }else{
            $errors="Ha ocurrido algún error. Por favor, inténtelo de nuevo más tarde";
        }

        return redirect()->back()->withErrors($errors);

    }

    /**
     * Elimina usuarios
     * @param  [type] [description]
     * @return [type] [description]
     */
    public function destroy($slug){
        if(!has_permiso('Borrar usuarios')){
            return view('errors.403');

        }
        $user = $this->userRepo->get_mis_datos($slug);
        $user->delete();
        return redirect()->route('lista-usuarios')->with('status', 'Usuario eliminado correctamente.');
            
    }

    /**
     * Muestra la lista de todos los usuarios
     * @param  [type] [description]
     * @return [type] [description]
     */
    public function listar_usuarios(){

        if(!has_permiso('Ver lista usuarios')){
            return view('errors.403');
        }
       
        $data['usuarios'] = $this->userRepo->todos_los_usuarios();        

        return view('users.lista-usuarios', compact('data'));


    }

    public function construir_slug($string){
        //tomamos el nombre y apellidos insertados para construir el slug base
        $baseslug = normalizar_string($string);

        //Miramos si ese slug ya existe
        $existe = User::where('slug', $baseslug)->count();  

        //Si no existe, lo guardamos
        if($existe == 0){
            $string = $baseslug;
        //si existe, añadimos un contador al final (2, porque sería el segundo usuario con ese nombre)
        }else{
            $i = 2;
            $slug=$baseslug.'-'.$i;
            $existe = User::where('slug', $slug)->count(); 
                //volvemos a checkear si existe. Mientras exista el slug ($existe sea = 1)
            while ($existe > 0){
                // añadimos uno al contador 
                $i = $i+1;    
                $slug = $baseslug.'-'.$i;
                //y volvemos a checkear
                $existe = User::where('slug', $slug)->count(); 
            }
            //cuando no encontremos el slug en la bbdd ($existe = 0), guardamos el slug 
            $string = $slug;
        }
        return $string;
    }

    public function update_permisos($slug, Request $request){

        $inputs = $request->all();

        $user = $this->userRepo->get_mis_datos($slug);

        $permisos_user = $user->permiso()->lists('permiso_id')->toArray();

        $permisos_del_rol = $user->role->permiso->lists('id')->toArray(); //es un array

        if(isset($inputs['permiso'])){ 

            //para los permisos del usuario
            foreach($inputs['permiso'] as $permiso_user){
                //si el nuevo permiso no está en la lista de permisos personalizados, lo añadimos
                if(!in_array($permiso_user, $permisos_user)){
                    $user->permiso()->attach($permiso_user);
                }
            }
            foreach($permisos_user as $permiso){
                //si alguno de los permisos personalizados se ha quitado, lo eliminamos
                if(!in_array($permiso, $inputs['permiso'])){
                    $user->permiso()->detach($permiso, ['permitido' =>1]);
                }
            }
            //para los permisos del rol 
            foreach($permisos_del_rol as $per){
                //si se ha eliminado alguno de ellos se cambia el estado permitido a 0
                if(!in_array($per, $inputs['permiso'])){
                    $user->permiso()->attach($per,['permitido' => 0]);
                //si no, se eliminan de la lista de permisos perosnalizados (ya que lo recogera de los permisos del rol)
                }else{
                    $user->permiso()->detach($per);
                }
            }

        //si no hay ningún permiso seleccionado (no hay permisos personalizados Y se han eliminado todos los propios del rol)
        }else{
            foreach ($permisos_user as $permiso) {
                $user->permiso()->detach($permiso);
            } 
            foreach ($permisos_del_rol as $per) {
                $user->permiso()->attach($per,['permitido' => 0]);            
            } 
        }

        return redirect()->back();
    }

    public function mis_cupones($slug){

        $data['mis-datos'] = $this->userRepo->get_mis_datos($slug);

        $data['cupones'] = $data['mis-datos']->cupon;

        return view('users.mis-cupones', compact('data'));

    }

    public function validacion_usuarios(){
    }



}
