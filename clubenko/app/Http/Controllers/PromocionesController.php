<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Requests
use App\Http\Requests;
use App\Http\Requests\PromocionRequest;

//Controllers
use App\Http\Controllers\LikeController;
use App\Http\Controllers\TiendasController;
use App\Http\Controllers\ValidacionesController;
use App\Http\Controllers\PagosController;

//Models
use App\Models\Bloque;
use App\Models\Promocion;

//Repositories
use App\Repositories\TiendaRepo;
use App\Repositories\PromocionRepo;
use App\Repositories\CategoriaRepo;
use App\Repositories\SubcategoriaRepo;
use App\Repositories\ComentarioRepo;
use App\Repositories\ValorarPromocionesRepo;
use App\Repositories\BloqueRepo;
use App\Repositories\FiltroRepo;

//Others
use PDF;
use Auth;
use Storage;
use Carbon\Carbon;
use BrowserDetect;
use Plugins\zanox\ApiClient;

class PromocionesController extends Controller
{

    protected $likeController;

    public function __construct(PromocionRepo $promocionRepo,
                                TiendaRepo $tiendaRepo,
                                CategoriaRepo $categoriaRepo,
                                SubcategoriaRepo $subcategoriaRepo,
                                FiltroRepo $filtroRepo,
                                ComentarioRepo $comentarioRepo,
                                LikeController $likeController,
                                BloqueRepo $bloqueRepo,
                                TiendasController $tiendasController,
                                ValorarPromocionesRepo $valorarPromocionesRepo,
                                ValidacionesController $validacionesController,
                                PagosController $pagosController)

    {
        $this->promocionRepo = $promocionRepo;
        $this->tiendaRepo = $tiendaRepo;
        $this->categoriaRepo = $categoriaRepo;
        $this->subcategoriaRepo = $subcategoriaRepo;
        $this->filtroRepo = $filtroRepo;
        $this->comentarioRepo = $comentarioRepo;
        $this->likeController = $likeController;
        $this->bloqueRepo = $bloqueRepo;
        $this->tiendasController = $tiendasController;
        $this->valorarPromocionesRepo = $valorarPromocionesRepo;
        $this->validacionesController = $validacionesController;
        $this->pagosController = $pagosController;
    }

    /**
     * Muestra la lista de promociones
     * @param  [type] [description]
     * @return view [lista]
     */
    public function index(){
        if(!has_permiso('Ver lista promociones'))
        {
            return view('errors.403');
        }
        
        $data['promociones'] = $this->promocionRepo->promociones_por_validar();

        return view('dashboard.validaciones.lista-promociones', compact('data'));

    }

    /**
     * Muestra el formulario de creación de promociones
     * @param  string [devuelve el slug de la tienda para poder asociarlo luego]
     * @return view [formulario]
     */
    public function create(){
        if(!has_permiso('Crear promociones'))
        {
            return view('errors.403');
        }
        //dd(Auth::user()->tienda);

        $data['filtros'] = $this->filtroRepo->get_filtros();

        $data['categorias'] = $this->categoriaRepo->get_categorias();
        $data['subcategorias'] = $this->subcategoriaRepo->get_subcategorias();
        $data['tiendas'] = Auth::user()->tienda()->where('confirmado', 1)->get();

        return view('dashboard.promociones.nuevo', compact('data'));

    }

    /**
     * Almacena los datos del nuevo promocion 
     * @param  [type] [description]
     * @return view [vista previa del nuevo promocion]
     */
    public function store(PromocionRequest $request){

        $request = $request->all();

        //si la fecha fin esta declarada, pero vacia devolvemos un errror
        if( isset($request['fecha_fin']) && $request['fecha_fin'] ==  "")
        {
            return redirect()->back()->withErrors('Por favor, introduzca la fecha de fin.')->withInput();
        }

        //el valor minimo de un precio con descuento el de 50 centimos
        if($request['precio_descuento'] < '0.50'){
            return redirect()->back()->withErrors('El precio con el descuento no puede ser menor de 0.50€')->withInput();
        }

        //si se ha marcado ilimitado para la fecha fin marcamos la fecha maxima posible
        if(isset($request['ilimitado'])){
            $request['fecha_fin'] = '9999-12-31';
        }

        if($request['tipo_promocion'] == 'reserva'){
            $request['reserva']  = true;
        }else{
            $request['reserva']  = false;
        }


        //definimos el slug del promocion
        $request['slug'] = self::construir_slug($request['titulo']);

        //definimos la imagen del promocion
        $request['imagen'] = $request['logo'];

        //si no se ha elegido una subcaregoria, guardamos null
        if(!isset($request['subcategoria_id'])){
            $request['subcategoria_id'] = null;
        }    


        $promocion = $this->promocionRepo->crear_promocion($request);

        if(has_permiso('Validar promociones')){

            // Validamos la promoción, verificará si tiene permisos o no.
            $this->validacionesController->validar($promocion);

            $mensaje = 'Promoción creada correctamente y validada.';
        }
        else{
            $mensaje = 'Promoción creada correctamente, pendiente de validación.';
        }
        
        //asociamos el promocion a las tiendas elegidas
        if(isset($request['tienda'])){
            foreach($request['tienda'] as $tienda){
              $promocion->tienda()->attach($tienda);
    		  
            }
        }

        //asociamos el promocion al usuario que lo ha creado
        $promocion->user()->attach(Auth::user()->id);

        return redirect()->route('listar-promociones', Auth::user()->slug)->withErrors($mensaje);

        //return back()->with('status', 'Cupón creado correctamente. A la espera de ser revisado');

    }

    /**
     * Muestra la vista del promocion
     * @param  [string] [slug del promocion]
     * @return view [vista del promocion]
     */
    public function show($slug){

        $data['promocion'] = self::get_datos_promocion($slug);
        $promocion = $data['promocion'];

        $data['comentarios'] =  self::get_comentarios_promocion($data['promocion']);
        if(Auth::check()){
            $comentario_existe = $this->comentarioRepo->get_comentario(Auth::user()->id, $data['promocion']->id);
        }else{
            $comentario_existe = null;
        }

        //dd($comentario_existe);
        //ponemos los corazones de like sobre los objetos
        $data['promocion'] = $this->likeController->poner_corazones_like($data['promocion'], get_tipo_de_objeto($data['promocion']));

        //Sacamosel número de descargas del cupón
        $data['descargas_promocion'] = self::get_total_descargas($data['promocion']);

        //Sumamos las descargas a los likes
        $data['promocion']->likes = $data['promocion']->likes + $data['descargas_promocion']->descargas;


        if(has_permiso('Editar promociones') && BrowserDetect::isDesktop()){
            return redirect()->route('promociones.edit', [ 'slug' => $slug]);
        }else{
            return return_vistas('public.promocion',$data);
        }

    }
    
    /**
     * Muestra el formulario de edición del cupón
     * @param  [string] [slug del cupón]
     * @return view [formulario]
     */
    public function edit($slug){

        if(!has_permiso('Editar promociones')){         
            return redirect('errors.403');
        }


        $data['filtros'] = $this->filtroRepo->get_filtros();
        $data['categorias'] = $this->categoriaRepo->get_categorias();
        $data['subcategorias'] = $this->subcategoriaRepo->get_subcategorias();

        //Sacamos las imágenes para editar el cupón
        $data['imagenes_promocion'] = self::imagenes_promocion();

        $data['promocion'] = self::get_datos_promocion($slug);

        ///Sacamos las imágenes para editar el cupón
        $data['imagenes_promocion'] = self::imagenes_de_carpeta($data['promocion']->categoria->slug);

        // Colocamos las iamgenes con su slug delante
        $data['imagenes_promocion'] = self::colocar_imagenes_en_select($data['imagenes_promocion'], $data['promocion']->categoria->slug, 'cupones', $data['promocion']->imagen);

        //Guardamos en un array los IDs de las tiendas donde está el cupón
        $data['tiendas_promocion'] = array();

        foreach ($data['promocion']->tienda as $key => $tienda) {
            $data['tiendas_promocion'][] = $tienda->id;
        }

        //Sacamos las tiendas de un cupón
        $data['tiendas'] = self::tiendas_del_promocion($data['promocion']);

        return view('dashboard.promociones.editar', compact('data'));

    }
    
    /**
     * Actualiza los datos del cupón
     * @param  [string] [slug del cupón]
     * @return view [vista del cupón]
     */
    public function update($slug, PromocionRequest $request){
        if(!has_permiso('Editar promociones')){         
            return redirect('errors.403');
        }

        //si la fecha fin esta declarada, pero vacia devolvemos un errror
        if( isset($request['fecha_fin']) && $request['fecha_fin'] ==  "")
        {
            return redirect()->back()->withErrors('Por favor, introduzca la fecha de fin.')->withInput();
        }

        //el valor minimo de un precio con descuento el de 50 centimos
        if($request['precio_descuento'] < '0.50'){
            return redirect()->back()->withErrors('El precio con el descuento no puede ser menor de 0.50€')->withInput();
        }

        //si se ha marcado ilimitado para la fecha fin marcamos la fecha maxima posible
        if(isset($request['ilimitado'])){
            $request['fecha_fin'] = '9999-12-31';
        }

        $data['promocion'] = self::get_datos_promocion($slug);

        $data['promocion']->titulo = $request->titulo;
        $data['promocion']->descripcion = $request->descripcion;
        $data['promocion']->descripcion_corta = $request->descripcion_corta;

        $data['promocion']->fecha_inicio = $request->fecha_inicio;
        $data['promocion']->fecha_fin = $request->fecha_fin;

        $data['promocion']->categoria_id = $request->categoria_id;
        if($request->subcategoria_id == ''){
            $data['promocion']->subcategoria_id = null;
        }else{
            $data['promocion']->subcategoria_id = $request->subcategoria_id;
        }

        $data['promocion']->filtro_id = $request->filtro_id;

        $data['promocion']->precio = $request->precio;
        $data['promocion']->precio_descuento = $request->precio_descuento;

 
        if($request['tipo_promocion'] == 'reserva'){
            $data['promocion']->reserva = true;
        }
        else{
            $data['promocion']->reserva = false;
        }
        
        $data['promocion']->logo = $request->logo_tienda;

        $data['promocion']->confirmado = false;

        if(has_permiso('Validar promociones')){
            // Validamos el cupón, verificará si tiene permisos o no.
            $data['promocion']->confirmado = true;

            $mensaje = 'Promoción editada correctamente y validado.';
        }
        else{

            $data['promocion']->confirmado = false;

            $mensaje = 'Promoción editada correctamente! Debe ser validada.';
        }


        $data['promocion']->save();
        
        if($request->logo != ''){
            $data['promocion']->imagen = $request->logo;
            $data['promocion']->save();
            
        }


        foreach(Auth::user()->tienda as $tienda){
            $data['promocion']->tienda()->detach($tienda);
        }
        foreach($request->tienda as $tienda){
            $data['promocion']->tienda()->attach($tienda);
        }

        return redirect()->route('listar-promociones', Auth::user()->slug)->withErrors($mensaje);

    }
    
    /**
     * Elimina el cupón
     * @param  [type] [description]
     * @return view [description]
     */
    public function borrar($slug){
        if(!has_permiso('Borrar promociones')){
            return view('errors.403');
        }
        $data['promocion'] = self::get_datos_promocion($slug);
        return view('dashboard.promociones.eliminar-promocion', compact('data'));
    }
    
    /**
     * Elimina el cupón
     * @param  [type] [description]
     * @return view [description]
     */
    public function destroy($slug){
        if(!has_permiso('Borrar promociones')){
            return view('errors.403');
        }
        $promocion = self::get_datos_promocion($slug);
        $promocion->delete();
        return redirect()->route('listar-promociones', Auth::user()->slug)->withErrors('Promoción borrado correctamente');
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
        $existe = Promocion::where('slug', $baseslug)->count();  

        //Si no existe, lo guardamos
        if($existe == 0){
            $string = $baseslug;
        //si existe, añadimos un contador al final (2, porque sería el segundo usuario con ese nombre y apellido)
        }else{
            $i = 2;
            $slug=$baseslug.'-'.$i;
            $existe = Promocion::where('slug', $slug)->count(); 
                //volvemos a checkear si existe. Mientras exista el slug ($existe sea = 1)
            while ($existe > 0){
                // añadimos uno al contador 
                $i = $i+1;    
                $slug = $baseslug.'-'.$i;
                //y volvemos a checkear
                $existe = Promocion::where('slug', $slug)->count(); 
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
        $data['datos-promocion'] = self::get_datos_promocion($slug);
       
        $promocion = $data['datos-promocion'];

        $imagen = $promocion->tienda()->first()->usuario()->first()->imagen;

        $promocion->descargas = $data['datos-promocion']->descargas + 1;

        $promocion->save();

        $pdf = PDF::loadView('promociones.pdf', compact('data', 'promocion', 'imagen'));
        //return $pdf->stream();
        return $pdf->download($data['datos-promocion']->titulo.'.pdf');

    }

    public function listar_promociones(){
       

        $data['promociones'] = $this->promocionRepo->promociones_activos();

        return view('dashboard.promociones.promociones', compact('data'));

    }

    public function listar_promociones_caducados(){
        
        $data['promociones'] = $this->promocionRepo->promociones_caducados();
       

        return view('dashboard.promociones.caducados', compact('data'));

    }

    public function listar_promociones_programados(){
        

        $data['promociones'] = $this->promocionRepo->promociones_programados();
        return view('dashboard.promociones.programados', compact('data'));

    }

    public function duplicar($slug){
        if(!has_permiso('Crear promociones')){
            return view('errors.403');
        }
        $data['filtros'] = $this->filtroRepo->get_filtros();
        $data['categorias'] = $this->categoriaRepo->get_categorias();
        $data['subcategorias'] = $this->subcategoriaRepo->get_subcategorias();
        $data['tiendas'] = Auth::user()->tienda()->where('confirmado', 1)->get();

        $data['promocion'] = self::get_datos_promocion($slug);

        return view('dashboard.promociones.duplicar-promocion', compact('data'));
    }

    public function guardar_duplicado($slug, PromocionRequest $request){

        //si la fecha fin esta declarada, pero vacia devolvemos un errror
        if( isset($request['fecha_fin']) && $request['fecha_fin'] ==  "")
        {
            return redirect()->back()->withErrors('Por favor, introduzca la fecha de fin.')->withInput();
        }

        //si se ha marcado ilimitado para la fecha fin marcamos la fecha maxima posible
        if(isset($request['ilimitado'])){
            $request['fecha_fin'] = '9999-12-31';
        }

        $promocion_nuevo = [
              "categoria" => $request->categoria_id,
              "subcategoria" => $request->subcategoria_id,
              "logo" => $request->logo ,
              //"tienda" => $request->tienda ,
              "fecha_inicio" => $request->fecha_inicio,
              "fecha_fin" => $request->fecha_fin,
              "titulo" => $request->titulo,
              "filtro" => $request->filtro_id,
              "descripcion_corta" => $request->descripcion_corta,
              "descripcion" => $request->descripcion,
              "precio" =>  $request->precio,
              "precio_descuento" =>  $request->precio_descuento,
        ];
        //dd($promocion_nuevo);
        $promocion_old = self::get_datos_promocion($slug);

        $duplicar = [
              "categoria" => $promocion_old->categoria_id ,
              "subcategoria" => $promocion_old->subcategoria_id ,
              "logo" => $promocion_old->imagen ,
              //"tienda" => $promocion_old->tienda->toArray() ,
              "fecha_inicio" => $promocion_old->fecha_inicio ,
              "fecha_fin" => $promocion_old->fecha_fin ,
              "titulo" => $promocion_old->titulo ,
              "filtro" => $promocion_old->filtro_id ,
              "descripcion_corta" => $promocion_old->descripcion_corta ,
              "descripcion" => $promocion_old->descripcion,
              "precio" =>  $request->precio,
              "precio_descuento" =>  $request->precio_descuento,
        ];

        if($duplicar == $promocion_nuevo){
            return redirect()->back()->withInput()->withErrors('Por favor, modifique algún dato antes de guardar el cupón.');
        }

        $request = $request->all();

        //si la fecha fin esta declarada, pero vacia devolvemos un errror
        if( isset($request['fecha_fin']) && $request['fecha_fin'] ==  "")
        {
            return redirect()->back()->withErrors('Por favor, introduzca la fecha de fin.')->withInput();
        }

        //el valor minimo de un precio con descuento el de 50 centimos
        if($request['precio_descuento'] < '0.50'){
            return redirect()->back()->withErrors('El precio con el descuento no puede ser menor de 0.50€')->withInput();
        }

        //si se ha marcado ilimitado para la fecha fin marcamos la fecha maxima posible
        if(isset($request['ilimitado'])){
            $request['fecha_fin'] = '9999-12-31';
        }

        if($request['tipo_promocion'] == 'reserva'){
            $request['reserva']  = true;
        }


        //definimos el slug del promocion
        $request['slug'] = self::construir_slug($request['titulo']);

        //definimos la imagen del promocion
        $request['imagen'] = $request['logo'];

        //si no se ha elegido una subcaregoria, guardamos null
        if(!isset($request['subcategoria_id'])){
            $request['subcategoria_id'] = null;
        }    

        $promocion = $this->promocionRepo->crear_promocion($request);

        //asociamos el promocion a las tiendas elegidas
        if(isset($request['tienda'])){
            foreach($request['tienda'] as $tienda){
              $promocion->tienda()->attach($tienda);
              
            }
        }
        

        //asociamos el promocion al usuario que lo ha creado
        $promocion->user()->attach(Auth::user()->id);

        if($promocion->save())
        {
            return redirect()->route('listar-promociones', Auth::user()->slug)->withErrors('La promocion se ha duplicado correctamente. Está pendiente de validación.');
        }

    }



    /**
     * Sacamos las imágenes de una carpeta para los promociones 
     * @param  [type] [description]
     * @return array [array con el nombre de las imágenes]
     */
    private function imagenes_promocion()
    {
        //Abrimos el directorio donde están las imágenes de los promociones
        $directorio = opendir(base_path().'/public/img/cupones');

        //Declaramos el array que vamos a devolver con las imágenes
        $arr_imgagenes_promociones = array();

        //obtenemos un archivo y luego otro sucesivamente
        while ($archivo = readdir($directorio))
        {
            //verificamos si es o no un directorio
            if (!is_dir($archivo))
            {
                $arr_imgagenes_promociones[] = $archivo;
            }
        }
        
        return $arr_imgagenes_promociones;
    }



    public function mas_promociones_inicio()
    {
        return response()->json($this->promocionRepo->mas_promociones_inicio());
    }

    public function buscar_promocion(Request $request){
        $data['promociones'] =  $this->promocionRepo->buscar($request->busqueda);
        return view('dashboard.promociones.promociones', compact('data')); 

    }

    public function buscar_caducados(Request $request){
        $data['promociones'] = $this->promocionRepo->buscar_caducados($request->busqueda);
        return view('dashboard.promociones.caducados', compact('data')); 
        
    }

    public function buscar_programados(Request $request){
        $data['promociones'] = $this->promocionRepo->buscar_programados($request->busqueda);
        
        return view('dashboard.promociones.programados', compact('data')); 
        
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

    public function promocion_descuento($id){
        $from = substr($id, 0, 2);
        if($from == 'td'){
            $id_promocion = substr($id,  2, strlen($id));
            return view('promociones.promocion-descuento', compact('id_promocion'));

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
            $promociones = json_decode($json, true);
            $id_promocion = array_search($id, array_column($promociones['incentiveItems']['incentiveItem'], '@id'));
          
            $data = $promociones['incentiveItems']['incentiveItem'][$id_promocion];
//dd($data);
            return view('promociones.promocion-descuento', compact('data', 'id_promocion'));
        }

    }


    /**
     * [get_promociones_populares Sacamos los promociones populares]
     * @return [type] [description]
     */
    public function get_promociones_populares()
    {
        return $this->bloqueRepo->get_populares();
    }


    /**
     * [get_bloques_promociones Sacamos los bloques de los promociones]
     * @return [type] [description]
     */
    public function get_bloques_promociones()
    {
        return $this->bloqueRepo->get_all_bloques();
    }



    /**
     * [get_datos_promocion Obtenemos un cupón en función de su slug]
     * @param  [string] $promocion_slug [slug del promocion]
     * @return [type]             [description]
     */
    public function get_datos_promocion($promocion_slug = null)
    {
        if (is_null($promocion_slug)) {
            return null;
        }
        return $this->promocionRepo->get_datos_promocion($promocion_slug);
    }


    /**
     * [get_comentarios_promocion Pasando el promocion, nos devuelve sus comentarios]
     * @param  [type] $promocion [description]
     * @return [type]        [description]
     */
    public function get_comentarios_promocion($promocion)
    {
        if (is_null($promocion)) {
            return null;
        }
        return $this->comentarioRepo->get_comentarios_promocion($promocion->id);
    }


    /**
     * [get_comentario_promocion_usuario description]
     * @param  [type] $user  [description]
     * @param  [type] $promocion [description]
     * @return [type]        [description]
     */
    public function get_comentario_promocion_usuario($user_id = null, $promocion_id = null)
    {
        if (is_null($promocion_id) || is_null($user_id)) {
            return null;
        }

        return $this->comentarioRepo->get_comentario($user_id, $promocion_id);
    }


    public function get_total_descargas($promocion = null)
    {
        if (is_null($promocion)) {
            return null;
        }
        return $this->promocionRepo->total_descargas($promocion->id);
    }


    public function tiendas_del_promocion($promocion = null)
    {
        if (is_null($promocion)) {
            return null;
        }
        return $promocion['user'][0]->tienda;
    }



    public function get_promocion_por_filtro($categoria_id = null , $filtro_id = null)
    {
        if (is_null($filtro_id) || is_null($categoria_id)) {
            return null;
        }
        return $this->promocionRepo->promociones_categoria_filtro($categoria_id, $filtro_id);
    }


    /**
     * Sacamos un cupón a partir de una fecha, es decir, el primer cupón a partir de la fecha dada
     * @param  [type] $desktop_promocion_principal->fecha_corte_promocion [description]
     * @return [type]                                             [description]
     */
    public function get_promocion_a_partir_fecha($fecha_corte_promocion)
    {
        return $this->promocionRepo->gete_promocion_publicado_a_apartir_fecha($fecha_corte_promocion);
    }



    /**
     * [Scaamos un promocion random publicado y valido
     * @return [type] [description]
     */
    public function get_promocion_random_publicado()
    {
        return $this->promocionRepo->get_promocion_random_publicado();
    }



    /**
     * Sacamos los promociones publicados
     * @return [type] [description]
     */
    public function get_promocion_publicado()
    {
        return $this->promocionRepo->total_promociones_activos();
    }


    /**
     * Devolvemos un promocion por si ID siempre que esté publicado
     * @param  [type] $promocion_id [description]
     * @return [type]           [description]
     */
    public function find_promocion_id_publicado($promocion_id = null)
    {
        return $this->promocionRepo->find_promocion_id_publicado($promocion_id);
    }



    /**
     * Devolvemos los promociones de una provincia paginados
     * @param  string $provincia_id id de la provincia
     * @return [type]                 [description]
     */
    public function get_promociones_por_provincia($provincia_id)
    {
        $tiendas_de_la_provincia = $this->tiendasController->get_tiendas_por_provincia($provincia_id);

        //inicializamos el array de promociones por tienda
        $arr_promociones_provincia = array();

        //Recorremos las tiendas de la provincia
        foreach ($tiendas_de_la_provincia as $key => $tienda) {

            $promociones_activos = $tienda->promociones_activos;

            //por cada tienda, recorremos sus promociones activos y los guardamos
            foreach ($promociones_activos as $key_tienda => $promocion) {
                $arr_promociones_provincia[$promocion->id] = $promocion->id;
            }
            
        }

        $arr_promociones_provincia = $this->promocionRepo->get_promociones_whereIn($arr_promociones_provincia);
        
        return $arr_promociones_provincia;

    }


    /**
     * NO SE USA
     * Sacamos los promociones de cada provincia
     * @return [type] [description]
     */
    public function get_provincias_con_promociones()
    {
      //Sacamos las provincias
      $provincias = Provincias::all();

      //Sacamos las tiendas activas
      $tiendas = $this->tiendasController->get_todas_tiendas_validadas();

      $arr_provincias_promociones = array();
      $arr_provincias_promociones_no = array();

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
          if (isset($arr_provincias_promociones[$resp['results'][0]['address_components'][2]['long_name']])) {
            $arr_provincias_promociones[$resp['results'][0]['address_components'][2]['long_name']] += $tienda->promociones_activos->count();
          }
          else{
            $arr_provincias_promociones[$resp['results'][0]['address_components'][2]['long_name']] = $tienda->promociones_activos->count();
          }
        }

      }

      //Recorremos las privincias y añadimos sus promociones
      foreach ($provincias as $key => $provincia) {
        if (isset($arr_provincias_promociones[$provincia->nombre])) {
          $provincia->promociones = $arr_provincias_promociones[$provincia->nombre];
        }
      }

      return $provincias;
    }

    /**
     * [aumentar_vistar_promocion añadimos una vista mas en la base de daots]
     * @param  [int] $promocion_id [ID del promocion al que le sumamos una visita]
     * @return [type]           [description]
     */
    public function aumentar_vistar_promocion($promocion_id = null){
        return $this->promocionRepo->aumentar_vista_promocion($promocion_id);
    }

    /**
     * [get_valoracion_user obtenemos la valoracion de un usaurio en un promocion]
     * @param  [int] $promocion_id [ID promocion]
     * @return [object]           [object(Valorarpromociones)]
     */
    public function get_valoracion_user($promocion_id = null){
        return $this->valorarPromocionesRepo->get_valoracion_user($promocion_id);
    }

    /**
     * [valorar_promocion guardamos la valoracion de un promocion]
     * @param  Request $request [datos recibidos de una post ajax]
     * @return [repsons]    json       [valor_promocion => nuevo valor del promocion]
     */
    public function valorar_promocion(Request $request){

        //recogemos los datos del request
        $datos_nuevos['user_id'] = auth()->user()->id;
        $datos_nuevos['promocion_id'] = $request->cupon_id;
        $datos_nuevos['valoracion'] = $request->value;

        //guardamos la nueva valoracions
        $this->valorarPromocionesRepo->insert($datos_nuevos);

        //obtenemos el promocion de la base de datos
        $promocion = Promocion::find($request->cupon_id);

        if($promocion->valoracion == 0){
            //si la valoracion del promocion es cero, se trata de la primera valoracion
            $promocion->valoracion = $request->value;
        }else{
            //si ya tiene una valoracion, hacemos una media con la nueva valoracion, y redondeamos el valor resultate
            $promocion->valoracion = round( ($promocion->valoracion + $request->value)/2 );
        }

        //guardamos el nuevo valor de valoracion
        $promocion->save();

        return response()->json(['valor_cupon'=>$promocion->valoracion]);
    }


    /**
     * Sacamos los nuevos cupones y hacemos un random
     * @return [type] [description]
     */
    public function get_random_nuevas_promociones()
    {   
        // Establecemos cuantas promociones acamos de la BD
        $num_random = 4;

        // Establecemos cuantas promociones vamos a devolver
        $num_seleccionados = 20;

        // Sacamos los cupones de la BD
        return $this->promocionRepo->get_random_nuevas_promociones($num_random, $num_seleccionados);

    }


    /**
     * Sacamos las promociones más vistas
     * @return [type] [description]
     */
    public function get_promociones_mas_vistos()
    {
        return $this->promocionRepo->get_promociones_mas_vistos();
    }


    /**
     * Mostramos la vista para realizar el pago.
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function pago_promocion($slug = null){

        if (!$slug) {
            return redirect()->back();
        }

        //obtenemos la informacion de la promocion
        $data = self::get_datos_promocion($slug);
        
        //si no exite redireccionamos
        if (!$data) {
            return redirect()->back();
        }

        return return_vistas('public.pagos',$data);
    }


    /**
     * Realizamos el pago de la promocion
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function realizar_pago(Request $request)
    {

        //obtenemos la informacion de la promocion
        $promocion = self::get_datos_promocion($request->slug);

        $pago = $this->pagosController->realizar_pago($request);

        if ($pago[0]) {

            $promocion->descargas_user()->attach(Auth::user()->id);

            return redirect()->route('pago_promocion_confirmado',[$request->slug]);
        }
        else{
            if (isset($pago[1])) {
                return redirect()->back()->withErrors($pago[1]);
            }
            else{
                return redirect()->route('pago_promocion_denegado');
            }
            
        }

    }

}
