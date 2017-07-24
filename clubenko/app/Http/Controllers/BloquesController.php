<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Request
use App\Http\Requests\BloqueRequest;
use App\Http\Requests\BannerHomeRequest;



//Models
use App\Models\Cupon;
use App\Models\Bloque;
use App\Models\Banners;

//Controllers
use App\Http\Controllers\CuponesController;



use App\Repositories\CategoriaRepo;
use App\Repositories\SubcategoriaRepo;
use App\Repositories\CuponRepo;
use App\Repositories\BloqueRepo;
use App\Repositories\UserRepo;
use Auth;
use Carbon\Carbon;

use Log;

class BloquesController extends Controller
{

	public function __construct(CategoriaRepo $categoriaRepo,
                                CuponRepo $cuponRepo,
                                BloqueRepo $bloqueRepo,
                                SubcategoriaRepo $subcategoriaRepo,
                                UserRepo $userRepo,
                                CuponesController $cuponesController)
    {
        //$this->middleware('auth');
        $this->categoriaRepo = $categoriaRepo;
        $this->subcategoriaRepo = $subcategoriaRepo;
        $this->cuponRepo = $cuponRepo;
        $this->bloqueRepo = $bloqueRepo;
        $this->userRepo = $userRepo;
        $this->cuponesController = $cuponesController;
    }


    public function index(){

        if(!has_permiso('Editar home')){
            return view('errors.403');
        }

    	$data['cupones'] = $this->cuponRepo->total_cupones_activos();
        //$data['mas_cupones'] = $this->cuponRepo->get_cupones()->splice(3, 25);
        //$data['bloques'] = $this->bloqueRepo->get_all_bloques();
        //$data['portadas'] = $this->bloqueRepo->get_portadas();

        $data['categorias'] = $this->categoriaRepo->get_categorias();
        $data['subcategorias'] = $this->subcategoriaRepo->get_subcategorias();   	
        $data['comercios'] = $this->userRepo->get_comercios();
       
        $data['bloques'] = $this->bloqueRepo->get_all_bloques();

        $data['desktop_cupon_principal'] = $this->bloqueRepo->get_desktop_cupon_principal_home();

        $bloques = count($data['bloques']->where('tipo', 'bloque')); 

        return view('dashboard.gestion.editor-inicio', compact('data', 'bloques'));
    
    }

    public function create(){}
    public function store(){}
    public function show(){}

    public function edit(){

    }

    public function update($id, Request $request){

        $data['bloque'] = $this->bloqueRepo->get_datos_bloque($id);

        $data['bloque']->texto_portada = $request->texto;
        
        $data['bloque']->enlace_portada = $request->enlace;

        $data['bloque']->save();

        return redirect()->back();

    }

    /**
     * [buscador_cupones Recibimos POST y buscamos en la BD de cupones las coincidencias para mostrarlas en una talba en el front]
     * @return [type] [description]
     */
    public function buscador_cupones(Request $request)
    {
        //dd($request->all());
        $categoria = $request->categoria;
        $subcategoria = $request->subcategoria;
        $comercio = $request->comercio;
        
        if($subcategoria != ''){
            $resultado_busqueda = $this->cuponRepo->buscador_cupones_inicio($categoria, $subcategoria, '');
        }else{
            $resultado_busqueda = $this->cuponRepo->buscador_cupones_inicio($categoria, '', '');
        }
        if($comercio != ''){
            $resultado_busqueda = $this->cuponRepo->buscador_cupones_inicio('', '', $comercio);
        }
        //Generamos la tabla con el listado 
        
        $tabla =  "<div class='resultado' style='background-color:#B6B9BE'>";
        if(count($resultado_busqueda) == 0){
            $tabla .=  "<div class='row'><div class='col-md-12'><p>No existen resultados que coincidan con esa búsqueda</p></div></div>";
        }else{        
            foreach($resultado_busqueda->chunk(3) as $chunk){
                $tabla .= '<div class="row">';
                foreach($chunk as $cupon){
                    $imagen = $cupon->tienda->first()->usuario()->first()->imagen;
                    $nombre = $cupon->tienda->first()->usuario()->first()->name;
                    $comercio = $cupon->user->where('rol', 2)->first()->name;

                    if($cupon->logo == 'logo'){
                        if($imagen ==''){
                            $imagen_cupon = '<div class="logo-tienda"><img src="'.asset("/img/600x600.png").'" width="120px"></div>';
                        }else{
                            $imagen_cupon = '<div class="logo-tienda"><img src="'.asset($imagen).'" width="120px"></div>';
                        }
                    }elseif($cupon->logo == 'blanco'){
                        $imagen_cupon = '<div class="logo-blanco">'.$nombre.'</div>';
                    }elseif($cupon->logo == 'negro'){
                        $imagen_cupon = '<div class="logo-negro">'.$nombre.'</div>';

                    }

                    $tabla .=  "<div class='col-md-4'>
                                    <div class='promo cupon' id=".$cupon->id.">
                                        <div class='brand'>
                                                ".$imagen_cupon."  
                                        </div>
                                        <img src=".asset('img/cupones/'.$cupon->imagen).">
                                        <div class='datos-cupon'>
                                            <div class='tipo-descuento'>
                                                <p>".$cupon->filtro->nombre."</p>
                                            </div><div class='datos-descuento'>
                                                <p class='cupon-titulo'>$cupon->titulo</p>
                                                <p class='cupon-descripcion'>$cupon->descripcion_corta</p>
                                            </div>      
                                        </div>
                                    </div>
                                </div>";
                }
                $tabla .= "</div>";

            }
        }

        $tabla .= "</div>";

        if ($request->ajax()) {
            return response()->json(['tabla' => $tabla]);
        }

    }

    public function editar_bloques($id, Request $request){
        $bloque = $this->bloqueRepo->get_datos_bloque($id);

        if($request->cupon_id != ''){
            $bloque->cupon_id = $request->cupon_id;
        }

        if($request->cupon_id2 != ''){
            $bloque->cupon_id2 = $request->cupon_id2;
        }
        if($request->cat_bloque != ''){
            $categoria = $this->categoriaRepo->get_categoria_id($request->cat_bloque);
            $bloque->enlace = $categoria->slug;
        }

        if($bloque->save()){
            return redirect()->back();
        }else{
             return redirect()->back()->with('status', 'Error');
        }
    }

    public function nuevo_bloque(BloqueRequest $request){

        $nuevo_bloque = new Bloque();

        $nuevo_bloque->tipo = 'bloque';
        $nuevo_bloque->imagen = 'img/spa.png';
        //dd($request->all());
        if($request->subcat_bloque == null){
            $enlace = $this->categoriaRepo->get_categoria_id($request->cat_bloque);
        }else{
            $enlace = $this->subcategoriaRepo->get_subcategoria_id($request->subcat_bloque);
        }
        //dd($enlace->slug);

        $nuevo_bloque->enlace = $enlace->slug;

        if($request->primer_cupon != ''){
            $nuevo_bloque->cupon_id = $request->primer_cupon;
        }

        if($request->segundo_cupon != ''){
            $nuevo_bloque->cupon_id2 = $request->segundo_cupon;
        }

        if($nuevo_bloque->save()){
            return redirect()->back();
        }else{
             return redirect()->back()->with('status', 'Error')->withInput();
        }

    }

    public function destroy($id){

        $bloque = $this->bloqueRepo->get_datos_bloque($id);
        $bloque->delete();

        return redirect()->back();
    } 
    /*public function destroy( $id, Request $request ) {
        $bloque = Bloque::findOrFail( $id );

        if ( $request->ajax() ) {
            $bloque->delete( $request->all() );

            return response(['msg' => 'bloque deleted', 'status' => 'success']);
        }
    return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
}*/


    /**
     * Gestiona los banners de la cabecera, el primer banner de la cabecera.
     * @return [type] [description]
     */
    public function banner_cabecera()
    {   
        $data['banner'] = self::get_banner_cabecera();

        return view('dashboard.banners.cabecera',compact('data'));
    }



    /**
     * Gestiona los banners de la cabecera, el primer banner de la cabecera.
     * @return [type] [description]
     */
    public function banner_cabecera_edit(Request $request)
    {   

        $banner = self::get_banner_cabecera();

        if ($banner) {
            $banner->fill($request->all());
            $imagen = $request->imagen;
            $banner->save();
        }
        else{
            $request = $request->all();
            $request['slug'] = 'cabecera';
            $imagen = $request['imagen'];
            $banner = Banners::create($request);
        }

        //Subimos el banner de la home
        $banner->imagen = subir_imagen('imagen',$imagen, $banner->id, 'banner_cabecera');

        if ($banner->imagen) {
            $banner->save();
        }

        return redirect()->route('banner_cabecera')->withErrors('Banner editado correctamente');

    }



    /**
     * Gestiona los banners de la home, el primer banner de la home.
     * @return [type] [description]
     */
    public function banner_home()
    {   
        $data['banner'] = self::get_banner_home();

        return view('dashboard.banners.home',compact('data'));
    }



    /**
     * Gestiona los banners de la home, el primer banner de la home.
     * @return [type] [description]
     */
    public function banner_home_edit(Request $request)
    {   

        $banner = self::get_banner_home();

        if ($banner) {
            $banner->fill($request->all());
            $imagen = $request->imagen;
            $banner->save();
        }
        else{
            $request = $request->all();
            $request['slug'] = 'home';
            $imagen = $request['imagen'];
            $banner = Banners::create($request);
        }

        //Subimos el banner de la home
        $banner->imagen = subir_imagen('imagen',$imagen, $banner->id, 'banner_home');

        if ($banner->imagen) {
            $banner->save();
        }
        

        return redirect()->route('banner_home')->withErrors('Banner editado correctamente');

    }


    /**
     * Sacamos el banner de la cabecera
     * @return [type] [description]
     */
    public function get_banner_cabecera()
    {   
        return Banners::where('slug','cabecera')->first();
    }


    /**
     * Sacamos el banner de la home
     * @return [type] [description]
     */
    public function get_banner_home()
    {   
        return Banners::where('slug','home')->first();
    }


    /**
     * Sacamos los banners del menu
     * @return [type] [description]
     */
    public function get_banners_menu()
    {   
        return Bloque::where('tipo','banner_menu')->first();
    }


    /**
     * Guardamos el cupón principal de ClubEnko
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function bloque_desktop_cupon_principal(Request $request)
    {

        if (!$request->cupon_principal) {
            return redirect()->back()->withErrors('Debe seleccionar una opción para el cupón');
        }
        
        $bloque = $this->bloqueRepo->get_desktop_cupon_principal_home();

        if ($request->cupon_principal == 'select') {

            $cupon = Cupon::find($request->baner_principal);

            if ($cupon) {
                
                if ($bloque) {
                    $bloque->cupon_id = $request->baner_principal;
                    $bloque->fecha_corte_cupon = null;
                    $bloque->save();
                }
                else{
                    $bloque = new Bloque();
                    $bloque->tipo = 'desktop_cupon_principal';
                    $bloque->cupon_id = $request->baner_principal;
                    $bloque->save();
                }

            }
            else{
                return redirect()->back()->withErrors('No se ha seleccionado un cupón válido');
            }
            
        }

        elseif ($request->cupon_principal == 'fecha') {

            if (!$request->fecha_cupon_home) {
                return redirect()->back()->withErrors('No se ha seleccionado una fecha válida');
            }

            if ($bloque) {
                $bloque->fecha_corte_cupon = $request->fecha_cupon_home;
                $bloque->cupon_id = null;
                $bloque->save();
            }
            else{
                $bloque = new Bloque();
                $bloque->tipo = 'desktop_cupon_principal';
                $bloque->fecha_corte_cupon = $request->fecha_cupon_home;
                $bloque->cupon_id = null;
                $bloque->save();
            }

            return redirect()->route('bloques.index')->withErrors('Cupón principal editao correctamente');
        }

        elseif ($request->cupon_principal == 'random') {

            if ($bloque) {
                $bloque->fecha_corte_cupon = null;
                $bloque->cupon_id = null;
                $bloque->save();
            }
            else{
                $bloque = new Bloque();
                $bloque->tipo = 'desktop_cupon_principal';
                $bloque->fecha_corte_cupon = null;
                $bloque->cupon_id = null;
                $bloque->save();
            }

        }
        

        return redirect()->route('bloques.index')->withErrors('Cupón principal editao correctamente');
        
        
    }



    /**
     * Sacamos el cupon principal. Si no tiene uno definido, cogemos  
     * @return [type] [description]
     */
    public function get_desktop_cupon_principal_home()
    {
        $desktop_cupon_principal = $this->bloqueRepo->get_desktop_cupon_principal_home();

        //En caso de estar declararo un cupón lo mostramos
        if (isset($desktop_cupon_principal->cupon) && $desktop_cupon_principal->cupon) {
            return $desktop_cupon_principal->cupon;
        }

        //Si lo que está declarado es una fecha, filtraoms por la fecha
        elseif (isset($desktop_cupon_principal->fecha_corte_cupon) && !is_null($desktop_cupon_principal->fecha_corte_cupon)) {
            return $this->cuponesController->get_cupon_a_partir_fecha($desktop_cupon_principal->fecha_corte_cupon);
        }

        //Si no está marcada ninguna acción, sacamos uno por defecto.
        else{
            return $this->cuponesController->get_cupon_random_publicado();
        }
    }



    public function banners_menu()
    {
        $data['banners_menu'] = self::get_banners_menu();

        return view('dashboard.banners.menu',compact('data'));
    }



    public function banners_menu_edit(Request $request)
    {
        $banner_editar_id = $request->banner_menu;

        //Sacamos de la BD el banner
        $banners_menu = self::get_banners_menu();

        //Si no está creado, creamos le objeteo
        if (count($banners_menu) < 1) {
            $banners_menu = new Bloque();
            $banners_menu->tipo = 'banner_menu';
            $banners_menu->save();
        }


        //En funcióndel banner a editar, lo cambiamos
        if ($banner_editar_id == 1) {

            if ($request->imagen &&  $request->imagen != 'data:,') {
                $banners_menu->imagen = subir_imagen('imagen',$request->imagen, $banners_menu->id, 'banner_menu');
            }

            $banners_menu->enlace = $request->enlace;
            $banners_menu->save();

        }
        else{

            if ($request->imagen_dos &&  $request->imagen_dos != 'data:,') {
                $banners_menu->imagen_dos = subir_imagen('imagen_dos',$request->imagen_dos, $banners_menu->id, 'banner_menu_dos');
            }

            $banners_menu->enlace_dos = $request->enlace_dos;
            $banners_menu->save();
            
        }

        
                

        return redirect()->route('banners_menu')->withErrors('Banner editado correctamente');
    }
}
