<?php

namespace App\Http\Controllers;

use App\Http\Controllers\LikeController;

use Illuminate\Http\Request;
use App\Http\Requests\TiendaRequest;
use Auth;

//Models
use App\Models\Tienda;
use App\Models\Provincias;

use App\Repositories\TiendaRepo;
use App\Repositories\UserRepo;
use App\Repositories\CuponRepo;
use App\Models\Cupon;
use Carbon\Carbon;

class TiendasController extends Controller
{
    protected $likeController;
    
    public function __construct(UserRepo $userRepo,
                                TiendaRepo $tiendaRepo, 
                                CuponRepo $cuponRepo,
                                LikeController $likeController)
    {
        $this->userRepo = $userRepo;
        $this->tiendaRepo = $tiendaRepo;
        $this->cuponRepo = $cuponRepo;
        $this->likeController = $likeController;
    }
    
    /**      
    * [index muestra listado de tiendas por validar]     
    * @param  [] $nombre_variable [Que es la variable]      
    * @return view     
    */
    public function index(){

        if(!has_permiso('Validar tiendas')){
            return view('errors.403');
        }

        $data['tiendas'] = $this->tiendaRepo->tiendas_por_validar();

        return view('dashboard.validaciones.lista-tiendas', compact('data'));

    }

    /**      
    * [create muestra formulario de creación de tiendas]     
    * @param  [tipo_variable] $nombre_variable [Que es la variable]      
    * @return response     
    */
    public function create(){
        if(!has_permiso('Crear tiendas')){
            return view('errors.403');
        }

        $data['provincias'] = Provincias::all();

        return view('tiendas.nueva-tienda',compact('data'));
    }

    /**      
    * [store almacena información procedente del formulario de creación de tienda]     
    * @param  [tipo_variable] $nombre_variable [Que es la variable]      
    * @return response    
    */
    public function store(TiendaRequest $request){
        if(!has_permiso('Crear tiendas')){
            return view('errors.403');
        }

    	$tienda = new Tienda();
    	$tienda->nombre = $request->nombre;
        $tienda->slug = $this->construir_slug($request->nombre, 0);
        $tienda->web = $request->web;
        $tienda->latitud = $request->latitud;
        $tienda->longitud = $request->longitud;
        $tienda->telefono = $request->telefono;
        $tienda->direccion = $request->direccion;
        $tienda->provincia_id = $request->provincia_id;

        if(has_permiso('Validar tiendas')){
            $tienda->confirmado = true;
            $mensaje = 'Tienda creada correctamente y validada.';
        }
        else{
            $mensaje = 'Tienda creada correctamente. La nueva tienda se encuentra ahora pendiente de validación.';
        }

        $tienda->save();
		$tienda->usuario()->attach(Auth::user()->id);
        
        $data['mis-datos'] = $this->userRepo->get_mis_datos(Auth::user()->slug);
        $data['tiendas'] = Auth::user()->tienda()->where('confirmado', 1)->get();

        return redirect()->route('listar-tiendas',Auth::user()->slug)->withErrors($mensaje);

    }

    /**      
    * [edit muestra formulario de edición de tiendas]     
    * @param  string $slug       
    * @return response     
    */
    public function edit($slug){
        if(!has_permiso('Editar tiendas')){
            return view('errors.403');
        }

        $data['datos-tienda'] = $this->tiendaRepo->datos_tienda($slug);

        $data['provincias'] = Provincias::all();

        return view('tiendas.editar-tienda', compact('data'));

    }

    /**      
    * [update almacena información procedente del formulario de edición de tienda]     
    * @param string $slug [Que es la variable]      
    * @return response    
    */
    public function update($slug, Request $request){
        if(!has_permiso('Editar tiendas')){
            return view('errors.403');
        }

        $data['mis-datos'] = $this->userRepo->get_mis_datos(Auth::user()->slug);
        $tienda = $this->tiendaRepo->datos_tienda($slug);

        $tienda->nombre = $request->nombre;
        $tienda->direccion = $request->direccion;
        $tienda->latitud = $request->latitud;
        $tienda->longitud = $request->longitud;
        $tienda->telefono = $request->telefono;
        $tienda->web = $request->web;
        $tienda->provincia_id = $request->provincia_id;
        $tienda->direccion = $request->direccion;

        if(has_permiso('Validar tiendas')){
            $tienda->confirmado = true;
            $mensaje = 'Tienda editara correctamente y validada.';
        }
        else{
            $mensaje = 'Tienda editara correctamente. La nueva tienda se encuentra ahora pendiente de validación.';
        }

        $tienda->confirmado = false;

        $tienda->save();

        $data['datos-tienda'] = $tienda;

        return redirect()->route('ver_tienda',$tienda->slug)->withErrors($mensaje);

    }

    /**      
    * [show muestra información de tienda]     
    * @param  string $slug      
    * @return response    
    */
    public function show($slug){

        if(!has_permiso('Editar tiendas')){
            return view('errors.403');
        }

        $data['datos-tienda'] = $this->tiendaRepo->datos_tienda($slug);

        if (is_null($data['datos-tienda'])) {
            return redirect()->back()->withErrors('No se ha encontrado la tienda solictada');
        }

        return view('tiendas.tienda', compact('data'));


    }

     /**
     * Vista de borrar tienda
     * @param  [type] [description]
     * @return view [description]
     */
    public function borrar($slug){
        if(!has_permiso('Borrar tiendas')){
            return view('errors.403');
        }
        $data['datos-tienda'] = $this->tiendaRepo->datos_tienda($slug);
        
        return view('dashboard.tiendas.eliminar-tienda', compact('data'));
    }

    /**      
    * [destroy borra tienda (softdeletes)]     
    * @param  string $slug
    * @return response    
    */
    public function destroy($slug){
        if(!has_permiso('Borrar tiendas')){
            return view('errors.403');
        }

        $tienda = $this->tiendaRepo->datos_tienda($slug);
        if($tienda->cupon()->first() != null){
            return redirect()->back()->withErrors('No se pudo eliminar la tienda, tiene cupones asociados.');
        }

        $tienda->delete();

        if (es_administrador(Auth::user())) {
            return redirect()->route('ver-tiendas')->withErrors('Tienda eliminada correctamente.');
        }
        return redirect()->route('listar-tiendas',Auth::user()->slug)->withErrors('Tienda eliminada correctamente.');
        
    }

    /**      
    * [construir_slug normaliza el string con el que se construye el slug, 
    * revisa si el slug resultante ya existe, y si es así añade un contador 
    * @param  string $string nombre de la tienda      
    * @return string    
    */
    public function construir_slug($string, $id){
        //tomamos el string  para construir el slug base
        $baseslug = normalizar_string($string);

        //Miramos si ese slug ya existe
        if($id == 0){
            $existe = Tienda::where('slug', $baseslug)->count();  
        }else{
            $existe = Tienda::where('slug', $baseslug)->where('id', '!=', $id)->count();  
        }

        //Si no existe, lo guardamos
        if($existe == 0){
            $string = $baseslug;
        //si existe, añadimos un contador al final (2, porque sería el segundo )
        }else{
            $i = 2;
            $slug=$baseslug.'-'.$i;
            $existe = Tienda::where('slug', $slug)->count(); 
                //volvemos a checkear si existe. Mientras exista el slug ($existe sea = 1)
            while ($existe > 0){
                // añadimos uno al contador 
                $i = $i+1;    
                $slug = $baseslug.'-'.$i;
                //y volvemos a checkear
                $existe = Tienda::where('slug', $slug)->count(); 
            }
            //cuando no encontremos el slug en la bbdd ($existe = 0), guardamos el slug 
            $string = $slug;
        }
        return $string;
    }

    public function comercio($slug){

        $data['datos-tienda'] = $this->tiendaRepo->datos_tienda($slug);

        $data['cupones'] = $this->cuponRepo->cupones_tienda($data['datos-tienda']);
       //dd($data['cupones']);
        //ponemos los corazones de like sobre los objetos
        $data['datos-tienda'] = $this->likeController->poner_corazones_like($data['datos-tienda'], get_tipo_de_objeto($data['datos-tienda']));


        return view('public.comercio', compact('data'));

    }

    public function listar_tiendas(){
        if(!has_permiso('Gestionar tiendas')){
            return view('errors.403');
        }

        $data['tiendas'] = Auth::user()->tienda()->where('confirmado', 1)->get();

        return view('dashboard.tiendas.tiendas', compact('data'));
    }

    public function ver_all_tiendas(){
        if(!has_permiso('Gestionar tiendas')){
            return view('errors.403');
        }
        $data['tiendas'] = $this->tiendaRepo->get_tiendas();

        return view('tiendas.lista-tiendas', compact('data'));
        }



    /**
     * Pasamos objeto tiendas y devolvemos los puntos para el mapa google
     * @param  [type] $tiendas [description]
     * @return [type]          [description]
     */
    public function pintar_puntos_mapa($tiendas = null)
    {
        if (is_null($tiendas)) {
            return null;
        }

        $puntos = '';

        foreach ($tiendas as $tienda) {
            $puntos .= "var marker = new google.maps.Marker({map: map,position: {lat: ".$tienda->latitud . ", lng: " . $tienda->longitud . "}});";
        }

        return $puntos;
    }



    /**
     * Sacamos todas las tiendas validadas
     * @return [type] [description]
     */
    public function get_todas_tiendas_validadas()
    {
        return $this->tiendaRepo->get_todas_tiendas_validadas();
    }


    /**
     * Scamos la tienda en funcion de la provincia que le pasamos
     * @param  [type] $provincia_id [description]
     * @return [type]                 [description]
     */
    public function get_tiendas_por_provincia($provincia_id = null)
    {
        return $this->tiendaRepo->tiendas_por_provincia($provincia_id);
    }
}
