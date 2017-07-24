<?php

namespace App\Http\Controllers;

//Modulo
use App\Models\Bloque;


use App\Http\Controllers\LikeController;
use App\Http\Controllers\TiendasController;
use App\Http\Controllers\ValidacionesController;


use App\Repositories\TiendaRepo;
use Illuminate\Http\Request;
use App\Repositories\CuponRepo;
use App\Repositories\CategoriaRepo;
use App\Repositories\SubcategoriaRepo;
use App\Repositories\ComentarioRepo;
use App\Repositories\BloqueRepo;
use App\Repositories\FiltroRepo;
use App\Repositories\ValorarCuponesRepo;

use PDF;
use Auth;
use Storage;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Requests\CuponRequest;
use App\Models\Cupon;
use BrowserDetect;

use Plugins\zanox\ApiClient;

class CuponesController extends Controller
{

    protected $likeController;

    public function __construct(CuponRepo $cuponRepo,
                                TiendaRepo $tiendaRepo,
                                CategoriaRepo $categoriaRepo,
                                SubcategoriaRepo $subcategoriaRepo,
                                FiltroRepo $filtroRepo,
                                ComentarioRepo $comentarioRepo,
                                LikeController $likeController,
                                BloqueRepo $bloqueRepo,
                                TiendasController $tiendasController,
                                ValorarCuponesRepo $valorarCuponesRepo,
                                ValidacionesController $validacionesController)

    {
        $this->cuponRepo = $cuponRepo;
        $this->tiendaRepo = $tiendaRepo;
        $this->categoriaRepo = $categoriaRepo;
        $this->subcategoriaRepo = $subcategoriaRepo;
        $this->filtroRepo = $filtroRepo;
        $this->comentarioRepo = $comentarioRepo;
        $this->likeController = $likeController;
        $this->bloqueRepo = $bloqueRepo;
        $this->tiendasController = $tiendasController;
        $this->valorarCuponesRepo = $valorarCuponesRepo;
        $this->validacionesController = $validacionesController;
    }

    /**
     * Muestra la lista de cupones
     * @param  [type] [description]
     * @return view [lista]
     */
    public function index(){
        if(!has_permiso('Ver lista cupones'))
        {
            return view('errors.403');
        }

        $data['cupones'] = $this->cuponRepo->cupones_por_validar();

        return view('dashboard.validaciones.lista-cupones', compact('data'));

    }

    /**
     * Muestra el formulario de creación de cupones
     * @param  string [devuelve el slug de la tienda para poder asociarlo luego]
     * @return view [formulario]
     */
    public function create(){
        if(!has_permiso('Crear cupones'))
        {
            return view('errors.403');
        }
        //dd(Auth::user()->tienda);

        $data['filtros'] = $this->filtroRepo->get_filtros();

        $data['categorias'] = $this->categoriaRepo->get_categorias();
        $data['subcategorias'] = $this->subcategoriaRepo->get_subcategorias();
        $data['tiendas'] = Auth::user()->tienda()->where('confirmado', 1)->get();

        return view('dashboard.cupones.nuevo', compact('data'));

    }

    /**
     * Almacena los datos del nuevo cupon 
     * @param  [type] [description]
     * @return view [vista previa del nuevo cupon]
     */
    public function store(CuponRequest $request){

        if(!has_permiso('Crear cupones'))
        {
            return false;
        }

        $request = $request->all();

        //si la fecha fin esta declarada, pero vacia devolvemos un errror
        if( isset($request['fecha_fin']) && $request['fecha_fin'] ==  "")
        {
            return redirect()->back()->withErrors('Por favor, introduzca la fecha de fin.')->withInput();
        }

        //si se ha marcado ilimitado para la fecha fin marcamos la fecha maxima posible
        if(isset($request['ilimitado'])){
            $request['fecha_fin'] = '9999-12-31';
        }

        //definimos el slug del cupon
        $request['slug'] = self::construir_slug($request['titulo']);

        //definimos la imagen del cupon
        $request['imagen'] = $request['logo'];

        //si no se ha elegido una subcaregoria, guardamos null
        if(!isset($request['subcategoria_id'])){
            $request['subcategoria_id'] = null;
        }

        if($request['tipo_descuento'] == 1){
            $request['filtro_id'] = 1;
        }elseif($request['tipo_descuento'] == 2){ 
            $request['filtro_id'] = $request['filtro'];
        }


        $cupon = self::crear_cupon($request);

        if(has_permiso('Validar cupones')){
            // Validamos el cupón, verificará si tiene permisos o no.
            $this->validacionesController->validar($cupon);

            $mensaje = 'Cupón creado correctamente y validado.';
        }
        else{
            $mensaje = 'Cupón creado correctamente, pendiente de validación.';
        }
        
        //asociamos el cupon a las tiendas elegidas
        if(isset($request['tienda'])){
            foreach($request['tienda'] as $tienda){
              $cupon->tienda()->attach($tienda);
    		  
            }
        }

        //asociamos el cupon al usuario que lo ha creado
        $cupon->user()->attach(Auth::user()->id);

        return redirect()->route('listar-cupones', Auth::user()->slug)->withErrors($mensaje);

        //return back()->with('status', 'Cupón creado correctamente. A la espera de ser revisado');

    }

    /**
     * Muestra la vista del cupon
     * @param  [string] [slug del cupon]
     * @return view [vista del cupon]
     */
    public function show($slug){

        $data['cupon'] = self::get_datos_cupon($slug);
        $cupon = $data['cupon'];


        $data['comentarios'] =  self::get_comentarios_cupon($data['cupon']);

        if(Auth::check()){
            $comentario_existe = $this->comentarioRepo->get_comentario(Auth::id(), $data['cupon']->id);
        }else{
            $comentario_existe = null;
        }

        //dd($comentario_existe);
        //ponemos los corazones de like sobre los objetos
        $data['cupon'] = $this->likeController->poner_corazones_like($data['cupon'], get_tipo_de_objeto($data['cupon']));

        //Sacamosel número de descargas del cupón
        $data['descargas_cupon'] = self::get_total_descargas($data['cupon']);

        //Sumamos las descargas a los likes
        $data['cupon']->likes = $data['cupon']->likes + $data['descargas_cupon']->descargas;


        if(has_permiso('Editar cupones') && BrowserDetect::isDesktop()){
            return redirect()->route('cupones.edit', [ 'slug' => $slug]);
        }else{
            return return_vistas('public.cupon',$data);
            //return view('public.cupon.cupon', compact('data', 'comentario_existe'));
        }

    }
    
    /**
     * Muestra el formulario de edición del cupón
     * @param  [string] [slug del cupón]
     * @return view [formulario]
     */
    public function edit($slug){

        if(!has_permiso('Editar cupones')){         
            return redirect('errors.403');
        }


        $data['filtros'] = $this->filtroRepo->get_filtros();
        $data['categorias'] = $this->categoriaRepo->get_categorias();
        $data['subcategorias'] = $this->subcategoriaRepo->get_subcategorias();

        $data['cupon'] = self::get_datos_cupon($slug);

        //Sacamos las imágenes para editar el cupón
        $data['imagenes_cupon'] = self::imagenes_de_carpeta($data['cupon']->categoria->slug);

        // Colocamos las iamgenes con su slug delante
        $data['imagenes_cupon'] = self::colocar_imagenes_en_select($data['imagenes_cupon'], $data['cupon']->categoria->slug, 'cupones', $data['cupon']->imagen);

        //Guardamos en un array los IDs de las tiendas donde está el cupón
        $data['tiendas_cupon'] = array();

        foreach ($data['cupon']->tienda as $key => $tienda) {
            $data['tiendas_cupon'][] = $tienda->id;
        }

        //Sacamos las tiendas de un cupón
        $data['tiendas'] = self::tiendas_del_cupon($data['cupon']);

        return view('dashboard.cupones.editar', compact('data'));

    }
    
    /**
     * Actualiza los datos del cupón
     * @param  [string] [slug del cupón]
     * @return view [vista del cupón]
     */
    public function update($slug, CuponRequest $request){
        if(!has_permiso('Editar cupones')){         
            return redirect('errors.403');
        }

        //si la fecha fin esta declarada, pero vacia devolvemos un errror
        if( isset($request['fecha_fin']) && $request['fecha_fin'] ==  "")
        {
            return redirect()->back()->withErrors('Por favor, introduzca la fecha de fin.')->withInput();
        }

        //si se ha marcado ilimitado para la fecha fin marcamos la fecha maxima posible
        if(isset($request['ilimitado'])){
            $request['fecha_fin'] = '9999-12-31';
        }

        $data['cupon'] = self::get_datos_cupon($slug);

        $data['cupon']->titulo = $request->titulo;
        $data['cupon']->descripcion = $request->descripcion;
        $data['cupon']->descripcion_corta = $request->descripcion_corta;

        $data['cupon']->fecha_inicio = $request->fecha_inicio;
        $data['cupon']->fecha_fin = $request->fecha_fin;

        $data['cupon']->categoria_id = $request->categoria_id;
        if($request->subcategoria_id == ''){
            $data['cupon']->subcategoria_id = null;
        }else{
            $data['cupon']->subcategoria_id = $request->subcategoria_id;
        }

        if($request->tipo_descuento == 1){
            $data['cupon']->filtro_id = 1;
        }elseif($request->tipo_descuento == 2){ 
            if($request->filtro != $data['cupon']->filtro->nombre){
                $data['cupon']->filtro_id = $request->filtro;
            }

        }
        
        $data['cupon']->condiciones = $request->condiciones;

        $data['cupon']->logo = $request->logo_tienda;

        if(has_permiso('Validar cupones')){
            // Validamos el cupón, verificará si tiene permisos o no.
            $data['cupon']->confirmado = true;

            $mensaje = 'Cupón editado correctamente y validado.';
        }
        else{

            $data['cupon']->confirmado = false;

            $mensaje = 'Cupón editado correctamente! Debe ser validado.';
        }

        
        $data['cupon']->save();
        
        if($request->logo != ''){
            $data['cupon']->imagen = $request->logo;
            $data['cupon']->save();
            
        }

        foreach(Auth::user()->tienda as $tienda){
            $data['cupon']->tienda()->detach($tienda);
        }
        foreach($request->tienda as $tienda){
            $data['cupon']->tienda()->attach($tienda);
        }

        return redirect()->route('listar-cupones', Auth::user()->slug)->withErrors($mensaje);

    }
    
    /**
     * Elimina el cupón
     * @param  [type] [description]
     * @return view [description]
     */
    public function borrar($slug){
        if(!has_permiso('Borrar cupones')){
            return view('errors.403');
        }
        $data['cupon'] = self::get_datos_cupon($slug);
        return view('dashboard.cupones.eliminar-cupon', compact('data'));
    }
    
    /**
     * Elimina el cupón
     * @param  [type] [description]
     * @return view [description]
     */
    public function destroy($slug){
        if(!has_permiso('Borrar cupones')){
            return view('errors.403');
        }
        $cupon = self::get_datos_cupon($slug);
        $cupon->delete();
        return redirect()->route('listar-cupones', Auth::user()->slug)->withErrors('Cupón borrado correctamente');
    }
    /**
     * Construye el slug del cupón
     * @param  [string] [datos para construir el slug]
     * @return string [slug construido]
     */
    public function construir_slug($string){
        //tomamos el nombre y apellidos insertados para construir el slug base
        $baseslug = normalizar_string($string);

        //Miramos si ese slug ya existe
        $existe = Cupon::where('slug', $baseslug)->count();  

        //Si no existe, lo guardamos
        if($existe == 0){
            $string = $baseslug;
        //si existe, añadimos un contador al final (2, porque sería el segundo usuario con ese nombre y apellido)
        }else{
            $i = 2;
            $slug=$baseslug.'-'.$i;
            $existe = Cupon::where('slug', $slug)->count(); 
                //volvemos a checkear si existe. Mientras exista el slug ($existe sea = 1)
            while ($existe > 0){
                // añadimos uno al contador 
                $i = $i+1;    
                $slug = $baseslug.'-'.$i;
                //y volvemos a checkear
                $existe = Cupon::where('slug', $slug)->count(); 
            }
            //cuando no encontremos el slug en la bbdd ($existe = 0), guardamos el slug 
            $string = $slug;
        }
        return $string;
    }

    /**
     * Crea el pdf para descargar. NO FUNCIONAL 
     * @param  [type] [description]
     * @return view [description]
     */
    public function pdf($slug){
        $data['datos-cupon'] = self::get_datos_cupon($slug);
       
        $cupon = $data['datos-cupon'];

        $imagen = $cupon->tienda()->first()->usuario()->first()->imagen;

        $cupon->descargas_user()->attach(Auth::user()->id);

        $cupon->descargas = $data['datos-cupon']->descargas + 1;

        $cupon->save();

        $pdf = PDF::loadView('cupones.pdf', compact('data', 'cupon', 'imagen'));
        //return $pdf->stream();
        return $pdf->download($data['datos-cupon']->titulo.'.pdf');

    }

    public function listar_cupones(){
        if(!has_permiso('Ver lista cupones')){
            return view('errors.403');
        }

        $data['cupones'] = $this->cuponRepo->cupones_activos();



        //dd($data['cupones']);

        return view('dashboard.cupones.cupones', compact('data'));

    }

    public function listar_cupones_caducados(){
        if(!has_permiso('Ver lista cupones')){
            return view('errors.403');
        }
        $data['cupones'] = $this->cuponRepo->cupones_caducados();
        //dd($data['cupones-caducados']->first() == '');

        return view('dashboard.cupones.caducados', compact('data'));

    }

    public function listar_cupones_programados(){
        if(!has_permiso('Ver lista cupones')){
            return view('errors.403');
        }

        $data['cupones'] = $this->cuponRepo->cupones_programados();
        return view('dashboard.cupones.programados', compact('data'));

    }

    public function duplicar($slug){
        if(!has_permiso('Crear cupones')){
            return view('errors.403');
        }
        $data['filtros'] = $this->filtroRepo->get_filtros();
        $data['categorias'] = $this->categoriaRepo->get_categorias();
        $data['subcategorias'] = $this->subcategoriaRepo->get_subcategorias();
        $data['tiendas'] = Auth::user()->tienda()->where('confirmado', 1)->get();

        $data['cupon'] = self::get_datos_cupon($slug);

        return view('dashboard.cupones.duplicar-cupon', compact('data'));
    }

    public function guardar_duplicado($slug, CuponRequest $request){

        //si la fecha fin esta declarada, pero vacia devolvemos un errror
        if( isset($request['fecha_fin']) && $request['fecha_fin'] ==  "")
        {
            return redirect()->back()->withErrors('Por favor, introduzca la fecha de fin.')->withInput();
        }

        //si se ha marcado ilimitado para la fecha fin marcamos la fecha maxima posible
        if(isset($request['ilimitado'])){
            $request['fecha_fin'] = '9999-12-31';
        }

        $cupon_nuevo = [
              "categoria" => $request->categoria_id ,
              "subcategoria" => $request->subcategoria_id ,
              "logo" => $request->logo ,
              //"tienda" => $request->tienda ,
              "fecha_inicio" => $request->fecha_inicio ,
              "fecha_fin" => $request->fecha_fin ,
              "titulo" => $request->titulo ,
              "filtro" => $request->filtro ,
              "descripcion_corta" => $request->descripcion_corta ,
              "descripcion" => $request->descripcion 
        ];
        //dd($cupon_nuevo);
        $cupon_old = self::get_datos_cupon($slug);

        $duplicar = [
              "categoria" => $cupon_old->categoria_id ,
              "subcategoria" => $cupon_old->subcategoria_id ,
              "logo" => $cupon_old->imagen ,
              //"tienda" => $cupon_old->tienda->toArray() ,
              "fecha_inicio" => $cupon_old->fecha_inicio ,
              "fecha_fin" => $cupon_old->fecha_fin ,
              "titulo" => $cupon_old->titulo ,
              "filtro" => $cupon_old->filtro_id ,
              "descripcion_corta" => $cupon_old->descripcion_corta ,
              "descripcion" => $cupon_old->descripcion 
        ];

        if($duplicar == $cupon_nuevo){
            return redirect()->back()->withInput()->withErrors('Por favor, modifique algún dato antes de guardar el cupón.');
        }

        $cupon = new Cupon();

        $cupon->titulo = $request->titulo;
        $cupon->descripcion = $request->descripcion;
        $cupon->descripcion_corta = $request->descripcion_corta;
        $cupon->slug = $this->construir_slug($request->titulo);
        $cupon->fecha_inicio = $request->fecha_inicio;
        $cupon->fecha_fin = $request->fecha_fin;
        $cupon->categoria_id = $request->categoria_id;
        
        if($request->subcategoria  == ''){
            $cupon->subcategoria_id = null;
        }else{
            $cupon->subcategoria_id = $request->subcategoria_id;
        }
        $cupon->filtro_id = $request->filtro;

        $cupon->condiciones = $request->condiciones;
        $cupon->save();


        if (isset($request->tienda)) {
            foreach($request->tienda as $tienda){
              $cupon->tienda()->attach($tienda);
              
            }
        }
        

        $cupon->user()->attach(Auth::user()->id);

        $cupon->imagen = $request->logo;
        if($cupon->save())
        {
            return redirect()->route('listar-cupones', Auth::user()->slug)->withErrors('El cupón se ha duplicado correctamente. Está pendiente de validación.');
        }

    }


    public function mas_cupones_inicio()
    {
        return response()->json($this->cuponRepo->mas_cupones_inicio());
    }

    public function buscar_cupon(Request $request){
        $data['cupones'] =  $this->cuponRepo->buscar($request->busqueda);
        return view('dashboard.cupones.cupones', compact('data')); 

    }

    public function buscar_caducados(Request $request){
        $data['cupones'] = $this->cuponRepo->buscar_caducados($request->busqueda);
        return view('dashboard.cupones.caducados', compact('data')); 
        
    }

    public function buscar_programados(Request $request){
        $data['cupones'] = $this->cuponRepo->buscar_programados($request->busqueda);
        
        return view('dashboard.cupones.programados', compact('data')); 
        
    }

    public function descuentos(){
        require_once public_path().'/plugins/zanox/ApiClient.php';
        
        $api = ApiClient::factory(PROTOCOL_JSON, VERSION_DEFAULT);
        $connectId = '5E4F70C4762B98F50597'; // Please fill in these two variables with the proper information
        $secretKey = 'Ab9540c45d5f42+b9d732261634e8c/d5b218E41'; // They can be found in the zanox Marketplace under "Links & Tools", "API"
        $zanoxAppID = '280E58D4451BAC2F974D';
        $publicKey= '476878046A1B5722565D';

        $api->setConnectId($connectId);
        $api->setSecretKey($secretKey);
        $api->setPublicKey($publicKey);

        $items      = 10;
        $programId  = array();
        $incentiveType = "coupons";
        $region = "ES";

        $json = $api->searchIncentives($programId, $items, $incentiveType, $region);
        $data = json_decode($json, true);

        return view('public.descuentos', compact('data'));

    }

    public function cupon_descuento($id){
        $from = substr($id, 0, 2);
        if($from == 'td'){
            $id_cupon = substr($id,  2, strlen($id));
            return view('cupones.cupon-descuento', compact('id_cupon'));

        }else{
            require_once public_path().'/plugins/zanox/ApiClient.php';
            $api = ApiClient::factory(PROTOCOL_JSON, VERSION_DEFAULT);
            $connectId = '5E4F70C4762B98F50597'; // Please fill in these two variables with the proper information
            $secretKey = 'Ab9540c45d5f42+b9d732261634e8c/d5b218E41'; // They can be found in the zanox Marketplace under "Links & Tools", "API"
            $zanoxAppID = '280E58D4451BAC2F974D';
            $publicKey= '476878046A1B5722565D';

            $api->setConnectId($connectId);
            $api->setSecretKey($secretKey);
            $api->setPublicKey($publicKey);

            $items      = 10;
            $programId  = array();
            $incentiveType = "coupons";
            $region = "ES";

            $json = $api->searchIncentives($programId, $items, $incentiveType, $region);
            $cupones = json_decode($json, true);
            $id_cupon = array_search($id, array_column($cupones['incentiveItems']['incentiveItem'], '@id'));
          
            $data = $cupones['incentiveItems']['incentiveItem'][$id_cupon];
//dd($data);
            return view('cupones.cupon-descuento', compact('data', 'id_cupon'));
        }

    }


    /**
     * [get_cupones_populares Sacamos los cupones populares]
     * @return [type] [description]
     */
    public function get_cupones_populares()
    {
        return $this->bloqueRepo->get_populares();
    }


    /**
     * [get_bloques_cupones Sacamos los bloques de los cupones]
     * @return [type] [description]
     */
    public function get_bloques_cupones()
    {
        return $this->bloqueRepo->get_all_bloques();
    }



    /**
     * [get_datos_cupon Obtenemos un cupón en función de su slug]
     * @param  [string] $cupon_slug [slug del cupon]
     * @return [type]             [description]
     */
    public function get_datos_cupon($cupon_slug = null)
    {
        if (is_null($cupon_slug)) {
            return null;
        }
        return $this->cuponRepo->get_datos_cupon($cupon_slug);
    }


    /**
     * [get_comentarios_cupon Pasando el cupon, nos devuelve sus comentarios]
     * @param  [type] $cupon [description]
     * @return [type]        [description]
     */
    public function get_comentarios_cupon($cupon)
    {
        if (is_null($cupon)) {
            return null;
        }
        return $this->comentarioRepo->get_comentarios_cupon($cupon->id);
    }


    /**
     * [get_comentario_cupon_usuario description]
     * @param  [type] $user  [description]
     * @param  [type] $cupon [description]
     * @return [type]        [description]
     */
    public function get_comentario_cupon_usuario($user_id = null, $cupon_id = null)
    {
        if (is_null($cupon_id) || is_null($user_id)) {
            return null;
        }

        return $this->comentarioRepo->get_comentario($user_id, $cupon_id);
    }


    public function get_total_descargas($cupon = null)
    {
        if (is_null($cupon)) {
            return null;
        }
        return $this->cuponRepo->total_descargas($cupon->id);
    }


    public function tiendas_del_cupon($cupon = null)
    {
        if (is_null($cupon)) {
            return null;
        }
        return $cupon['user'][0]->tienda;
    }



    public function get_cupon_por_filtro($categoria_id = null , $filtro_id = null)
    {
        if (is_null($filtro_id) || is_null($categoria_id)) {
            return null;
        }
        return $this->cuponRepo->cupones_categoria_filtro($categoria_id, $filtro_id);
    }


    /**
     * Sacamos un cupón a partir de una fecha, es decir, el primer cupón a partir de la fecha dada
     * @param  [type] $desktop_cupon_principal->fecha_corte_cupon [description]
     * @return [type]                                             [description]
     */
    public function get_cupon_a_partir_fecha($fecha_corte_cupon)
    {
        return $this->cuponRepo->gete_cupon_publicado_a_apartir_fecha($fecha_corte_cupon);
    }



    /**
     * [Scaamos un cupon random publicado y valido
     * @return [type] [description]
     */
    public function get_cupon_random_publicado()
    {
        return $this->cuponRepo->get_cupon_random_publicado();
    }



    /**
     * Sacamos los cupones publicados
     * @return [type] [description]
     */
    public function get_cupon_publicado()
    {
        return $this->cuponRepo->total_cupones_activos();
    }


    /**
     * Devolvemos un cupon por si ID siempre que esté publicado
     * @param  [type] $cupon_id [description]
     * @return [type]           [description]
     */
    public function find_cupon_id_publicado($cupon_id = null)
    {
        return $this->cuponRepo->find_cupon_id_publicado($cupon_id);
    }



    /**
     * Devolvemos los cupones de una provincia paginados
     * @param  string $provincia_id id de la provincia
     * @return [type]                 [description]
     */
    public function get_cupones_por_provincia($provincia_id)
    {
        $tiendas_de_la_provincia = $this->tiendasController->get_tiendas_por_provincia($provincia_id);

        //inicializamos el array de cupones por tienda
        $arr_cupones_provincia = array();

        //Recorremos las tiendas de la provincia
        foreach ($tiendas_de_la_provincia as $key => $tienda) {

            $cupones_activos = $tienda->cupones_activos;

            //por cada tienda, recorremos sus cupones activos y los guardamos
            foreach ($cupones_activos as $key_tienda => $cupon) {
                $arr_cupones_provincia[$cupon->id] = $cupon->id;
            }
            
        }

        $arr_cupones_provincia = $this->cuponRepo->get_cupones_whereIn($arr_cupones_provincia);
        
        return $arr_cupones_provincia;

    }


    /**
     * NO SE USA
     * Sacamos los cupones de cada provincia
     * @return [type] [description]
     */
    public function get_provincias_con_cupones()
    {
      //Sacamos las provincias
      $provincias = Provincias::all();

      //Sacamos las tiendas activas
      $tiendas = $this->tiendasController->get_todas_tiendas_validadas();

      $arr_provincias_cupones = array();
      $arr_provincias_cupones_no = array();

      foreach ($tiendas as $key => $tienda) {
    
        // url encode the address
        $address = urlencode($tienda->direccion);

        // google map geocode api url
        $url = "http://maps.google.com/maps/api/geocode/json?address={$address}";

        // get the json response
        $resp_json = file_get_contents($url);
       
        // decode the json
        $resp = json_decode($resp_json, true);

        //Obtenemos la provincia de la tienda
        if($resp['results'])
        { 
          //Si está definica la provincia sumamos resultados, si no, inicializamos el índice
          if (isset($arr_provincias_cupones[$resp['results'][0]['address_components'][2]['long_name']])) {
            $arr_provincias_cupones[$resp['results'][0]['address_components'][2]['long_name']] += $tienda->cupones_activos->count();
          }
          else{
            $arr_provincias_cupones[$resp['results'][0]['address_components'][2]['long_name']] = $tienda->cupones_activos->count();
          }
        }

      }

      //Recorremos las privincias y añadimos sus cupones
      foreach ($provincias as $key => $provincia) {
        if (isset($arr_provincias_cupones[$provincia->nombre])) {
          $provincia->cupones = $arr_provincias_cupones[$provincia->nombre];
        }
      }

      return $provincias;
    }
    
    /**
     * [get_four_random_cupon obtenemos 4 cupones aleatoriamente]
     * @return [array] [array de 4 object(Cupon) aleatorios]
     */
    public function get_four_random_cupon()
    {
        return $this->cuponRepo->get_four_ramdom_cupon();
    }



    /**
     * [aumentar_vistar_cupon añadimos una vista mas en la base de daots]
     * @param  [int] $cupon_id [ID del cupon al que le sumamos una visita]
     * @return [type]           [description]
     */
    public function aumentar_vistar_cupon($cupon_id = null){
        return $this->cuponRepo->aumentar_vista_cupon($cupon_id);
    }



    /**
     * [get_valoracion_user obtenemos la valoracion de un usaurio en un cupon]
     * @param  [int] $cupon_id [ID cupon]
     * @return [object]           [object(ValorarCupones)]
     */
    public function get_valoracion_user($cupon_id = null){
        return $this->valorarCuponesRepo->get_valoracion_user($cupon_id);
    }



    /**
     * [valorar_cupon guardamos la valoracion de un cupon]
     * @param  Request $request [datos recibidos de una post ajax]
     * @return [repsons]    json       [valor_cupon => nuevo valor del cupon]
     */
    public function valorar_cupon(Request $request){

        //recogemos los datos del request
        $datos_nuevos['user_id'] = auth()->user()->id;
        $datos_nuevos['cupon_id'] = $request->cupon_id;
        $datos_nuevos['valoracion'] = $request->value;

        //guardamos la nueva valoracions
        $this->valorarCuponesRepo->insert($datos_nuevos);

        //obtenemos el cupon de la base de datos
        $cupon = Cupon::find($request->cupon_id);

        if($cupon->valoracion == 0){
            //si la valoracion del cupon es cero, se trata de la primera valoracion
            $cupon->valoracion = $request->value;
        }else{
            //si ya tiene una valoracion, hacemos una media con la nueva valoracion, y redondeamos el valor resultate
            $cupon->valoracion = round( ($cupon->valoracion + $request->value)/2 );
        }

        //guardamos el nuevo valor de valoracion
        $cupon->save();

        return response()->json(['valor_cupon'=>$cupon->valoracion]);
    }


    /**
     * Sacamos los nuevos cupones y hacemos un random
     * @return [type] [description]
     */
    public function get_random_nuevos_cupones()
    {   
        // Establecemos cuantos cupones acamos de la BD
        $num_random = 4;

        // Establecemos cuantos cupones vamos a devolver
        $num_seleccionados = 20;

        // Sacamos los cupones de la BD
        return $this->cuponRepo->get_random_nuevos_cupones($num_random, $num_seleccionados);

    }



    /**
     * Scamos los cupones más vistos
     * @return [type] [description]
     */
    public function get_cupones_mas_vistos()
    {
        return $this->cuponRepo->get_cupones_mas_vistos();
    }


    /**
     * Creamos el cupón con los datos que nos pasan
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    private function crear_cupon($request){
        return Cupon::create($request);
    }


    /**
     * Sacamos las imágenes de una carpeta para los cupones 
     * @param  [type] [description]
     * @return array [array con el nombre de las imágenes]
     */
    private function imagenes_cupon($categoria_slug)
    {
        //Abrimos el directorio donde están las imágenes de los cupones
        $directorio = opendir(base_path().'/public/img/cupones/' . $categoria_slug);

        //Declaramos el array que vamos a devolver con las imágenes
        $arr_imgagenes_cupones = array();

        //obtenemos un archivo y luego otro sucesivamente
        while ($archivo = readdir($directorio))
        {
            //verificamos si es o no un directorio
            if (!is_dir($archivo))
            {
                $arr_imgagenes_cupones[] = $archivo;
            }
        }
        
        return $arr_imgagenes_cupones;
    }
}
