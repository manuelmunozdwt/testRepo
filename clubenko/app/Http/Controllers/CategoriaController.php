<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CategoriaRequest;

use App\Http\Controllers\CuponesController;


use App\Models\Categoria;
use App\Models\Cupon;
use App\Models\Subcategoria;

use App\Repositories\CuponRepo;
use App\Repositories\CategoriaRepo;
use App\Repositories\SubcategoriaRepo;
use App\Repositories\FiltroRepo;

use Carbon\Carbon;
use Auth;

class CategoriaController extends Controller
{
	public function __construct(CategoriaRepo $categoriaRepo,
								CuponRepo $cuponRepo,
								SubcategoriaRepo $subcategoriaRepo,
								FiltroRepo $filtroRepo,
								CuponesController $cuponesController)
	{
		$this->categoriaRepo = $categoriaRepo;
		$this->subcategoriaRepo = $subcategoriaRepo;
		$this->cuponRepo = $cuponRepo;
		$this->filtroRepo = $filtroRepo;
		$this->cuponesController = $cuponesController;
	}


	public function index(){
		if(!has_permiso('Ver lista categorías')){
			return view('errors.403');
		}
		$data['categorias'] = $this->categoriaRepo->categorias_por_validar();

		return view('dashboard.validaciones.listado-categorias', compact('data'));
		
	}

	public function create(){
		if(!has_permiso('Crear categoría')){
            return view('errors.403');
        }
		$data['categoria'] = self::datos_categoria('restaurantes');

        $data['categorias'] = $this->categoriaRepo->get_categorias();
        
        return view('dashboard.categorias.categorias', compact('data'));
	}

	public function store(CategoriaRequest $request){
		if(!has_permiso('Crear categoría')){
			return view('errors.403');
		}
		$categoria = new Categoria();
		$categoria->nombre = $request->nombre;
		$categoria->slug = normalizar_string($request->nombre);
		$categoria->imagen  ='img/user.png';

		if($categoria->save()){

			return redirect()->back()->withErrors('Enhorabuena, ha creado una categoría. La categoría '.$categoria->nombre.' está ahora pendiente de validación.');
		}

	}

	public function show(){}

	public function edit(){}
	

	public function update($slug, CategoriaRequest $request){
		
        $categoria = self::datos_categoria($slug);


		if($categoria->estandar == 1){
			if(!has_permiso('Editar categoría estándar')){
				return view('errors.403');
			}
		}else{
			if(!has_permiso('Editar categoría')){
				return view('errors.403');
			}			
		}	

        $categoria->nombre = $request->nombre;
        if($categoria->save()){
        	return redirect()->route('categorias.create')->withErrors('La categoría '.$categoria->nombre.' ha sido editada correctamente.');
        }else{
			return redirect()->route('categorias.create')->withErrors('Ha ocurrido algún error. Por favor, revise los campos.');

        }
	}

	public function destroy($slug){

		$categoria = self::datos_categoria($slug);

		if($categoria->estandar == 1){
			if(!has_permiso('Borrar categoría estándar')){
				return view('errors.403');
			}
		}else{
			if(!has_permiso('Borrar categoría')){
				return view('errors.403');
			}			
		}

		if($categoria->subcategoria()->first() == null){
			$categoria->delete();
		}else{
			return redirect()->route('categorias.create')->withErrors('No se puede borrar la categoría, ya que tiene subcategorías válidas o pendientes de validación.');
		}
		if(Auth::user()->rol == 3){
			return redirect()->route('categorias.index')->withErrors('Categoría eliminada correctamente');
		}else{
			return redirect()->route('categorias.create')->withErrors('Categoría eliminada correctamente');
		}


	}

	public function listar_categorias(){
	}

	public function ver_subcategorias($slug){
		if(!has_permiso('Editar categoría')){
			return view('errors.403');
		}
		$data['categoria'] = self::datos_categoria($slug);
		return view('dashboard.categorias.subcategorias', compact('data'));
	}


	public function todas_las_categorias()
	{
		return $this->categoriaRepo->get_categorias();
	}



	/**
	 * Sacamos las categorías más populares
	 * @param  [int] $num_categorias [Define el número de categorías populares que debemos devolver]
	 * @return [array objetc]                 [devuleve un array con las categorías más populares]
	 */
	public function get_categorias_populares($num_categorias = 5)
	{	
		return $this->categoriaRepo->categorias_populares($num_categorias);
	}




	/**
	 * [get_categoria_slug description]
	 * @param  [type] $slug [description]
	 * @return [type]       [description]
	 */
	public function get_categoria_slug($slug = null)
	{
		if (is_null($slug)) {
			return null;
		}
		
		return $this->categoriaRepo->datos_categoria($slug);
	}


	/**
     * Devuelve la categoría y los cupones de uan categoria de una categoría
     * @param  [type] [description]
     * @return view [description]
     */
	public function cupones_de_categoria($categoria_slug = null)
	{

		$data['categoria'] = self::datos_categoria($categoria_slug);

		$data['cupones'] = self::cupones_activos_categoria_paginado($data['categoria'],8);

		return $data;

	}

	/**
     * Devuelve la categoría y los cupones de uan categoria de una categoría
     * @param  [type] [description]
     * @return view [description]
     */
	public function promociones_de_categoria($categoria_slug = null)
	{

		$data['categoria'] = self::datos_categoria($categoria_slug);

		$data['cupones'] = self::promociones_activos_categoria_paginado($data['categoria'],8);

		return $data;

	}

	/**
     * Devuelve la categoría y los cupones de uan categoria de una categoría
     * @param  [type] [description]
     * @return view [description]
     */
	public function cupones_de_sub_categoria($subcategoria_slug = null)
	{

		$data['data_subcategoria'] = self::datos_subcategoria($subcategoria_slug);

		$data['cupones'] = self::cupones_activos_subcategoria_paginado($data['data_subcategoria'],8);

		return $data;

	}


	/**
	 * [cupones_activos_categoria Devuelve los cupones activos de una categoría]
	 * @param  [objeto] $categoria [Categoria]
	 * @return [type]            [description]
	 */
	private function cupones_activos_categoria($categoria = null)
	{
		if (is_null($categoria)) {
			return null;
		}

		return $categoria->cupones_activos;

	}



	/**
	 * [cupones_activos_categoria Devuelve los cupones activos de una categoría paginados]
	 * @param  [objeto] $categoria [Categoria]
	 * @return [type]            [description]
	 */
	private function cupones_activos_categoria_paginado($categoria = null,$num_paginacion = null)
	{
		if (is_null($categoria)) {
			return null;
		}

		return $categoria->cupones_activos_paginado($num_paginacion);

	}


	/**
	 * [cupones_activos_categoria Devuelve los cupones activos de una categoría paginados]
	 * @param  [objeto] $categoria [Categoria]
	 * @return [type]            [description]
	 */
	private function promociones_activos_categoria_paginado($categoria = null,$num_paginacion = null)
	{
		if (is_null($categoria)) {
			return null;
		}

		return $categoria->promociones_activos_paginado($num_paginacion);

	}



	/**
	 * [cupones_activos_categoria Devuelve los cupones activos de una categoría paginados]
	 * @param  [objeto] $categoria [Categoria]
	 * @return [type]            [description]
	 */
	private function cupones_activos_subcategoria_paginado($subcategoria = null,$num_paginacion = null)
	{
		if (is_null($subcategoria)) {
			return null;
		}

		return $subcategoria->cupones_activos_paginado($num_paginacion);

	}


	/**
	 * [filtros_categoria Devolvemos los filtros de la plataforma]
	 * @return [type] [description]
	 */
	public function filtros_categoria()
	{
		return $this->filtroRepo->get_filtros();
	}


	/**
	 * [datos_categoria Devuleve una categoría en función del slug]
	 * @param  [type] $categoria_slug [description]
	 * @return [type]                 [description]
	 */
	private function datos_categoria($categoria_slug = null)
	{
		if (is_null($categoria_slug)) {
			return null;
		}

		return $this->categoriaRepo->datos_categoria($categoria_slug);
	}



	/**
	 * [datos_categoria Devuleve una subcategoría en función del slug]
	 * @param  [string] $categoria_slug [slug]
	 * @return [type]                 [description]
	 */
	private function datos_subcategoria($subcategoria_slug = null)
	{
		if (is_null($subcategoria_slug)) {
			return null;
		}
			
		return $this->subcategoriaRepo->datos_subcategoria($subcategoria_slug);
	}


	/**
	 * [get_subcategoria_de_categoria Sacamos las subcategorías de una categoría]
	 * @param  [Objet] $categoria [Objeto Categoría]
	 * @return [type]            [description]
	 */
	public function get_subcategoria_de_categoria($categoria = null)
	{
		if (is_null($categoria)) {
			return null;
		}

		return $categoria->subcategoria;
	}
	


	/**
	 * [custom_categorias description]
	 * @return [type] [description]
	 */
	public function custom_categorias()
	{

		$data['categorias'] = $this->categoriaRepo->get_categorias();

		$data['cupones'] = $this->cuponesController->get_cupon_publicado();

		return view('dashboard.categorias.custom-categorias', compact('data'));
	}



	/**
	 * Devolvemos la información de la categoría solictada por POST
	 * @param  [type] $categoria_id [description]
	 * @return [type]               [description]
	 */
	public function custom_categorias_data(Request $request)
	{
		if (is_null($request->categoria_id)) {
			return null;
		}

		$categoria = Categoria::find($request->categoria_id);

		if (!$categoria) {
			return null;
		}

		//Sacamos los cupones de la categoria
		$categoria->cupon_sup =  Cupon::find($categoria->cupon_destacado_uno_id);
		$categoria->cupon_inf = Cupon::find($categoria->cupon_destacado_dos_id);

		//Pintamos los cupones
		if ($categoria->cupon_sup) {
			$categoria->cupon_sup = view('includes.cupon', ['cupon' => $categoria->cupon_sup]);
			$categoria->cupon_sup = $categoria->cupon_sup->render();
		}
		if ($categoria->cupon_inf) {
			$categoria->cupon_inf = view('includes.cupon', ['cupon' => $categoria->cupon_inf]);
			$categoria->cupon_inf = $categoria->cupon_inf->render();
		}

		return $categoria;

	}



	/**
	 * Guardamos la las opciones de la cartegoría
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function custom_categorias_edit(Request $request)
	{
		if (!isset($request->categoria_id)) {
			return redirect()->back()->witherror('No se ha podido cargar la categoría');
		}

		$categoria = Categoria::find($request->categoria_id);

		if (!$categoria) {
			return redirect()->back()->witherror('No se ha podido cargar la categoría');
		}

		if ($request->imagen &&  $request->imagen != 'data:,') {
			$categoria->banner_categoria = subir_imagen('imagen', $request->imagen, $request->categoria_id, 'categorias');
		}
		

		if ($request->cupon_superior) {
			$categoria->cupon_destacado_uno_id = $request->cupon_superior;
		}
		if ($request->cupon_inferior) {
			$categoria->cupon_destacado_dos_id = $request->cupon_inferior;
		}
		
		$categoria->banner_nombre = $request->nombre;
		$categoria->banner_alt = $request->alt;
		$categoria->banner_enlace = $request->enlace;

		$categoria->save();



		return redirect()->back()->witherror('Categoría editada correctamente');
	}
	
}





