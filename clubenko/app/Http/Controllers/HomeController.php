<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\CategoriaRepo;
use App\Repositories\CuponRepo;
use App\Repositories\PromocionRepo;

//Controllers
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\CuponesController;
use App\Http\Controllers\FiltroController;
use App\Http\Controllers\BloquesController;
use App\Http\Controllers\TiendasController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PromocionesController;


//Models
use App\Models\Provincias;

use Auth;
use BrowserDetect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CategoriaRepo $categoriaRepo,
                                CuponRepo $cuponRepo,
                                CategoriaController $categoriaController,
                                CuponesController $cuponesController,
                                ComentariosController $comentariosController,
                                LikeController $likeController,
                                TiendasController $tiendasController,
                                FiltroController $filtroController,
                                BloquesController $bloquesController,
                                PromocionesController $promocionesController,
                                PromocionRepo $promocionRepo)
    {
        //$this->middleware('auth');
        $this->categoriaRepo = $categoriaRepo;
        $this->cuponRepo = $cuponRepo;
        $this->categoriaController = $categoriaController;
        $this->cuponesController = $cuponesController;
        $this->likeController = $likeController;
        $this->comentariosController = $comentariosController;
        $this->tiendasController = $tiendasController;
        $this->filtroController = $filtroController;
        $this->bloquesController = $bloquesController;
        $this->promocionesController = $promocionesController;
        $this->promocionRepo = $promocionRepo;
    }


    /**
     * [welcome Mostramos el index ]
     * @return [type] [description]
     */
    public function welcome()
    {   
        /*if(identificar_dispositivo() == 'desktop'){
           CÓDIGO ANTIGUO
          if(Auth::check() && Auth::user()->rol == 2 || Auth::check() && Auth::user()->rol == 3){
              return redirect()->action('UsersController@show', Auth::user()->slug);
          }elseif(Auth::check() && Auth::user()->rol != 2){
            return redirect()->route('logout', Auth::user()->id);
          }else{
            return redirect()->route('login');
          }
          */

      //En caso de estar desde un móvil limitamos el número de elementos que mostramos, en otros dispositivos mostrmos todos
      

      $data['cupones'] =  self::mezclar_cupones_promociones();

      $data['categorias'] = $this->categoriaController->todas_las_categorias();
    
      $data['populares'] = $this->cuponesController->get_cupones_populares();

      $data['bloques'] = $this->cuponesController->get_bloques_cupones();

      //Sacamos le banner de la cabecera
      $data['banner-cabecera'] = $this->bloquesController->get_banner_cabecera();

      //Scamos el banner que va debajo del cupón principal
      $data['banner-home'] = $this->bloquesController->get_banner_home();

      //Sacamos el cupón principal de ClubEnko
      $data['desktop_cupon_principal'] = $this->bloquesController->get_desktop_cupon_principal_home();

      //Sacamos las 5 categorías más populares
      $data['categorias_populares'] = $this->categoriaController->get_categorias_populares(5);

      //Sacamos las provincias
      $data['provincias'] = Provincias::all();
      $data['provincias'] = $data['provincias']->chunk(9);

      //Sacamos los cupones más nuevos y hacemos un random
      $data['nuevos_cupones'] = $this->cuponesController->get_random_nuevos_cupones();

      //Sacamos las promociones más nuevas y hacemos un random
      $data['nuevas_promociones'] = $this->promocionesController->get_random_nuevas_promociones();

      //Sacamos las promociones más nuevas y hacemos un random
      $data['mas_visualizados'] = self::get_mas_vistos();


      

      return return_vistas('public.home',$data);
    }



    /**
     * [cupones_por_categoria Mostramos los cupones de una categoria]
     * @param  [type] $categoria_slug [Slug de la catgeoria]
     * @return [type]                 [description]
     */
    public function home_ver_categoria($categoria_slug = null)
    {

      if (is_null($categoria_slug)) {
        return redirect()->back();
      }

      //Sacamos el banner de la cabecera
      $data['banner-cabecera'] = $this->bloquesController->get_banner_cabecera();

      //Sacamos todas las caetegorias para el menú
      $data['categorias'] = $this->categoriaController->todas_las_categorias();

      //Cupones de esta categoria
      //$data['categoria'] 
      //$data['cupones']
      $cupones_de_categoria = $this->categoriaController->cupones_de_categoria($categoria_slug);
      $promociones_de_categoria = $this->categoriaController->promociones_de_categoria($categoria_slug);

      //Verificamos que la categoría exista
      if (!$cupones_de_categoria['categoria'] && $promociones_de_categoria) {
        return redirect()->back();
      }

      //
      $data['cupones'] = $cupones_de_categoria['cupones']->merge($promociones_de_categoria['cupones']);

      //Sacamos la categoría con su slug
      $data['categoria'] = $cupones_de_categoria['categoria'];

      //
      $data['filtros'] = $this->categoriaController->filtros_categoria();


      //Sacamos los cupones superior e inferior en caso de tenerlos
      $data['cupon_superior'] = $this->cuponesController->find_cupon_id_publicado($data['categoria']->cupon_destacado_uno_id);
      $data['cupon_inferior'] = $this->cuponesController->find_cupon_id_publicado($data['categoria']->cupon_destacado_dos_id);
   

      //Sacamos las categorias para listar el menú
      $data['subcategorias'] = $this->categoriaController->get_subcategoria_de_categoria($data['categoria']);

      $data['populares'] = $this->cuponesController->get_cupones_populares();

      $data['bloques'] = $this->cuponesController->get_bloques_cupones();

      $data['id'] = "0";

      return return_vistas('public.categorias',$data);

    }





    /**
     * [home_ver_subcategoria Mostramos los cupones de la subcategoría]
     * @param  [type] $subcategoria_slug [description]
     * @return [type]                    [description]
     */
    public function home_ver_subcategoria($categoria_slug = null,$subcategoria_slug = null)
    {

      if (is_null($subcategoria_slug)) {
        return redirect()->back();
      }

      //Sacamos el banner de la cabecera
      $data['banner-cabecera'] = $this->bloquesController->get_banner_cabecera();

      //Sacamos los cupones y los datos de la subcategoría
      $datos_subcategoria =  $this->categoriaController->cupones_de_sub_categoria($subcategoria_slug);

      $data['data_subcategoria'] = $datos_subcategoria['data_subcategoria'];

      //Verificamos que la categoría exista
      if (!$data['data_subcategoria']) {
        return redirect()->back();
      }

      $data['cupones'] = $datos_subcategoria['cupones'];

      $data['categoria'] = $data['data_subcategoria']->categoria;

      //Sacamos los cupones superior e inferior en caso de tenerlos
      $data['cupon_superior'] = $this->cuponesController->find_cupon_id_publicado($data['categoria']->cupon_destacado_uno_id);
      $data['cupon_inferior'] = $this->cuponesController->find_cupon_id_publicado($data['categoria']->cupon_destacado_dos_id);

      //Sacamos las categorias para listar el menú
      $data['subcategorias'] = $this->categoriaController->get_subcategoria_de_categoria($data['categoria']);

      $data['filtros'] = $this->categoriaController->filtros_categoria();

      $data['id'] = '0';

      return return_vistas('public.categorias',$data);

    }




    public function home_cupones_provincias($provincia_slug)
    {
      if (is_null($provincia_slug)) {
        return redirect()->back();
      }

      $data['provincia'] = Provincias::where('slug',$provincia_slug)->first();

      if (!$data['provincia']) {
        return redirect()->back();
      }

      //Sacamos el banner de la cabecera
      $data['banner-cabecera'] = $this->bloquesController->get_banner_cabecera();

      //Sacamos todas las caetegorias para el menú
      $data['categorias'] = $this->categoriaController->todas_las_categorias();

      //Cupones de esta categoria
      $data['cupones'] = $this->cuponesController->get_cupones_por_provincia($data['provincia']->id);

      if ($data['cupones']->count() > 20) {
        $data['columnas_vista'] = '4';
      }
      else{
        $data['columnas_vista'] = '2';
      }

      $data['filtros'] = $this->categoriaController->filtros_categoria();

      $data['populares'] = $this->cuponesController->get_cupones_populares();

      $data['bloques'] = $this->cuponesController->get_bloques_cupones();

      $data['id'] = "0";

      return view('public.provincias.desktop',compact('data'));
    }




    public function home_ver_categoria_filtro($categoria_slug = null, $filtro_id = null)
    {
      if (is_null($categoria_slug) || is_null($filtro_id)) {
        return false;
      }

      $data['categorias'] = $this->categoriaController->todas_las_categorias();

      //Cupones de esta categoria
      //$data['categoria'] 
      //$data['cupones']
      $cupones_de_categoria = $this->categoriaController->cupones_de_categoria($categoria_slug);

      //Verificamos que la categoría exista
      if (!$cupones_de_categoria['categoria']) {
        return redirect()->back();
      }

      //Sacamos la categoría con su slug
      $data['categoria'] = $cupones_de_categoria['categoria'];

      $data['cupones'] = $this->cuponesController->get_cupon_por_filtro($data['categoria']->id, $filtro_id);

      $data['filtros']  = $this->categoriaController->filtros_categoria();

      //$data['filtro'] = $this->filtroController->get_filtro($filtro_id);
        
      $data['subcategorias'] = $this->categoriaController->get_subcategoria_de_categoria($data['categoria']);

      $data['id'] = $filtro_id;

      return return_vistas('public.categorias',$data);

    }


    public function datos_comunes($cupon = null)
    {

      $data['cupon'] = $cupon;

      $data['comentarios'] =  $this->cuponesController->get_comentarios_cupon($data['cupon']);

      $data['comentarios'] =  $this->comentariosController->get_fecha_bonita_comentario($data['comentarios']);

      if(Auth::check()){
            $data['comentario_existe'] = $this->cuponesController->get_comentario_cupon_usuario(Auth::user()->id, $data['cupon']->id);
        }else{
            $data['comentario_existe'] = null;
        }

      //ponemos los corazones de like sobre los objetos
      $data['cupon'] = $this->likeController->poner_corazones_like($data['cupon'], get_tipo_de_objeto($data['cupon']));

      //Sacamos el número de descargas del cupón
      $data['descargas_cupon'] =  $this->cuponesController->get_total_descargas($data['cupon']);

      //Sumamos las descargas a los likes
      $data['cupon']->likes = $data['cupon']->likes + $data['descargas_cupon']->descargas;

      $data['tiendas'] = $data['cupon']->tienda;

      $data['puntos_mapa'] = $this->tiendasController->pintar_puntos_mapa($data['tiendas']);

      $data['tienda_mapa_centrado'] = $data['tiendas'][0];

      $data['cupones_recomendados'] = self::mezclar_cupones_promociones()->random(4);

      $data['otras_ofertas'] =  self::mezclar_cupones_promociones();

      return $data;

    }

    public function home_ver_cupon($slug = null){

      if (is_null($slug)) {
        return redirect()->back();
      }

      $data['cupon'] = $this->cuponesController->get_datos_cupon($slug);

      if (!$data['cupon'] || $data['cupon']->confirmado == '0') {
        return redirect()->back();
      }


      $this->cuponesController->aumentar_vistar_cupon($data['cupon']->id);

      $data = self::datos_comunes($data['cupon']);

      $data['valoracion_usario'] = $this->cuponesController->get_valoracion_user($data['cupon']->id);

      return return_vistas('public.cupon',$data);
    }



    public function home_ver_promocion($slug = null)
    {

      if (is_null($slug)) {
        return redirect()->back();
      }

      $data['cupon'] = $this->promocionesController->get_datos_promocion($slug);

      if (!$data['cupon'] || $data['cupon']->confirmado == '0') {
        return redirect()->back();
      }

      $this->promocionesController->aumentar_vistar_promocion($data['cupon']->id);

      $data = self::datos_comunes($data['cupon']);

      $data['valoracion_usario'] = $this->promocionesController->get_valoracion_user($data['cupon']->id);

      return return_vistas('public.cupon',$data);

    }




    /**
     * Scamoas las categorías más populares
     * @return [type] [description]
     */
    public function mostrar_populares_categoria()
    {
        $data['categorias'] = $this->categoriaRepo->get_categorias();

        return view('home', compact('data'));
    }

    public function politicas(){
      return view('public.politicas');
    }


    /**
     * Scamos los cupones y promociones más vistos y los mezclamos
     * @return [type] [description]
     */
    public function get_mas_vistos()
    {

      $cupones = $this->cuponesController->get_cupones_mas_vistos();

      $promociones = $this->promocionesController->get_promociones_mas_vistos();

      //juntamos los conjuntos de collecciones en una
      $merge_collection = $cupones->merge($promociones);

      //Ordenamos las colecciones por fecha de creación
      $merge_collection = $merge_collection->sortBy('created_at')->take(6);

      return $merge_collection;
      
    }


}
