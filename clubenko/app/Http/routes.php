<?php

use App\Models\Subcategoria as Subcategoria;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('politicas', [ 'as' => 'politicas', 'uses' => 'HomeController@politicas']);
Route::auth();
// route to show the login form
Route::get('login', ['as' => 'login' ,'uses' => 'Auth\AuthController@login']);
Route::get('registro', ['as' => 'registro' ,'uses' => 'Auth\AuthController@registro']);

// route to process the form
Route::post('login', ['uses' => 'Auth\AuthController@authenticate']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);

Route::get('reset-password', ['as' => 'reset-comercio', function () {
	return view('auth.passwords.email-comercio');
}]);

Route::post('registro-comercio', ['as' => 'registro-comercio', 'uses' => 'Auth\AuthController@create']);

/*
|--------------------------------------------------------------------------
| ZONA PÚBLICA
|--------------------------------------------------------------------------
|
| 
|
*/
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@welcome']);

Route::get('mas-cupones-inicio', ['as' => 'mas_cupones_inicio', 'uses' => 'CuponesController@mas_cupones_inicio']);

	/*
	|--------------------------------------------------------------------------
	| Categoria
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/
	Route::get('/categoria/{categoria_slug}', ['as' => 'home_ver_categoria', 'uses' => 'HomeController@home_ver_categoria']);
	Route::get('/categoria/{categoria_slug}/{subcategoria}', ['as' => 'home_ver_subcategorias', 'uses' => 'HomeController@home_ver_subcategoria']);
	Route::get('categorias/subcategoria/{subcategoria}', ['as' => 'subcategorias', 'uses' => 'HomeController@home_ver_subcategoria']);
	Route::get('categorias/buscar/{categoria_id}/{subcategoria_id}', ['as' => 'tipos', 'uses' => 'HomeController@home_ver_categoria_filtro']);
	Route::get('comercio/{tienda}', ['as' => 'comercio', 'uses' => 'TiendasController@comercio']);


	/*
	|--------------------------------------------------------------------------
	| Cupón
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/
	Route::get('cupon/{cupon_slug}', ['as' => 'home_ver_cupon', 'uses' => 'HomeController@home_ver_cupon']);

	Route::get('promocion/{promocion_slug}', ['as' => 'home_ver_promocion', 'uses' => 'HomeController@home_ver_promocion']);


	/*
	|--------------------------------------------------------------------------
	| CUPONES POR PROVINCIA
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/
	Route::get('provincia/{provincia_slug}', ['as' => 'home_cupones_provincias', 'uses' => 'HomeController@home_cupones_provincias']);



/*
|--------------------------------------------------------------------------
| ZONA PRIVADA
|--------------------------------------------------------------------------
|
| 
|
*/
Route::group(['middleware' => ['auth']], function () {

		Route::get('mis-datos', ['as' => 'mis_datos', 'uses' => 'UsersController@mis_datos']);

		Route::post('imagenes-por-categoria', ['as' => 'imagenes_por_categoria', 'uses' => 'Controller@imagenes_por_categoria']);


		


		/*
		|--------------------------------------------------------------------------
		| Cupón
		|--------------------------------------------------------------------------
		|
		| 
		|
		*/
		Route::get('cupon-pdf/{cupon}', ['as' => 'cupon-pdf', 'uses' => 'CuponesController@pdf']);
		Route::get('usuario/{slug}/mis-cupones', ['as' => 'mis-cupones', 'uses' => 'UsersController@mis_cupones']);
		Route::get('listar-cupones/{slug}', ['as' => 'listar-cupones', 'uses' => 'CuponesController@listar_cupones']);
		Route::get('lista-cupones-caducados/{slug}', ['as' => 'listar-cupones-caducados', 'uses' => 'CuponesController@listar_cupones_caducados']);
		Route::get('lista-cupones-programados/{slug}', ['as' => 'listar-cupones-programados', 'uses' => 'CuponesController@listar_cupones_programados']);
		Route::get('cupones/{slug}/borrar', ['as' => 'borrar-cupon', 'uses' => 'CuponesController@borrar']);
		Route::get('cupones/{slug}/duplicar', ['as' => 'duplicar-cupon', 'uses' => 'CuponesController@duplicar']);
		Route::post('cupones/{slug}/duplicar', ['as' => 'duplicar-cupon', 'uses' => 'CuponesController@guardar_duplicado']);
		Route::post('cupones/valorar-cupon', ['as' => 'valorar-cupon', 'uses' => 'CuponesController@valorar_cupon']);


		/*
		|--------------------------------------------------------------------------
		| PROMOCIONES
		|--------------------------------------------------------------------------
		|
		| 
		|
		*/
		Route::get('promocion-pdf/{promocion}', ['as' => 'promocion-pdf', 'uses' => 'PromocionesController@pdf']);
		Route::get('usuario/{slug}/mis-promociones', ['as' => 'mis-promociones', 'uses' => 'UsersController@mis_promociones']);
		Route::get('listar-promociones/{slug}', ['as' => 'listar-promociones', 'uses' => 'PromocionesController@listar_promociones']);
		Route::get('lista-promociones-caducados/{slug}', ['as' => 'listar-promociones-caducados', 'uses' => 'PromocionesController@listar_promociones_caducados']);
		Route::get('lista-promociones-programados/{slug}', ['as' => 'listar-promociones-programados', 'uses' => 'PromocionesController@listar_promociones_programados']);
		Route::get('promociones/{slug}/borrar', ['as' => 'borrar-promocion', 'uses' => 'PromocionesController@borrar']);
		Route::get('promociones/{slug}/duplicar', ['as' => 'duplicar-promocion', 'uses' => 'PromocionesController@duplicar']);
		Route::post('promociones/{slug}/duplicar', ['as' => 'duplicar-promocion', 'uses' => 'PromocionesController@guardar_duplicado']);
		Route::post('promociones/valorar-promocion', ['as' => 'valorar-promocion', 'uses' => 'PromocionesController@valorar_promocion']);

		Route::get('promocion/{slug}/pago', ['as' => 'pago_promocion', 'uses' => 'PromocionesController@pago_promocion']);
		Route::post('promocion/pago', ['as' => 'promocion_realizar_pago', 'uses' => 'PromocionesController@realizar_pago']);

		


		/*
		|--------------------------------------------------------------------------
		| TIENDAS
		|--------------------------------------------------------------------------
		|
		| 
		|
		*/
		Route::get('tiendas/{slug}/borrar', ['as' => 'borrar-tienda', 'uses' => 'TiendasController@borrar']);
		Route::get('tiendas/tiendas', ['as' => 'ver-tiendas', 'uses' => 'TiendasController@ver_all_tiendas']);


		/*
		|--------------------------------------------------------------------------
		|VALIDACIONES
		|--------------------------------------------------------------------------
		|
		| 
		|
		*/	
		Route::get('validar-cupones/{slug}', ['as' => 'validar-cupon', 'uses' => 'ValidacionesController@validar_cupon']);
		Route::get('validar-tiendas/{slug}', ['as' => 'validar-tienda', 'uses' => 'ValidacionesController@validar_tienda']);
		Route::get('validar-comentarios/{id}', ['as' => 'validar-comentario', 'uses' => 'ValidacionesController@validar_comentarios']);
		//Route::get('validar-usuarios', ['as' => 'validacion-usuarios', 'uses' => 'UsersController@index']);
		Route::get('validar-usuarios/{id}', ['as' => 'validar-usuarios', 'uses' => 'ValidacionesController@validar_usuarios']);
		Route::get('validar-categorias/{slug}', ['as' => 'validar-categoria', 'uses' => 'ValidacionesController@validar_categoria']);
		Route::get('validar-subcategorias/{slug}', ['as' => 'validar-subcategoria', 'uses' => 'ValidacionesController@validar_subcategoria']);
		Route::get('validar-promociones/{slug}', ['as' => 'validar-promocion', 'uses' => 'ValidacionesController@validar_promocion']);



		/*
		|--------------------------------------------------------------------------
		| LIKE OBJETEOS
		|--------------------------------------------------------------------------
		|
		| 
		|
		*/
		Route::get('like', ['as' => 'like', 'uses' => 'LikeController@like']);

		/*
		|--------------------------------------------------------------------------
		| GESTIÓN DE TIENDAS
		|--------------------------------------------------------------------------
		|
		| 
		|
		*/
		Route::resource('tiendas', 'TiendasController');
		Route::get('tiendas/detalle/{slug}', ['as' => 'ver_tienda', 'uses' => 'TiendasController@show']);
		Route::get('tiendas/listar-tiendas/{slug}', ['as' => 'listar-tiendas', 'uses' => 'TiendasController@listar_tiendas']);
		/*
		|--------------------------------------------------------------------------
		| GESTIÓN DE PERMISOS
		|--------------------------------------------------------------------------
		|
		| 
		|
		*/
		Route::resource('permisos', 'PermisosController');
		Route::post('permisos/{usuario}/update', ['as' => 'permisos-update', 'uses' => 'UsersController@update_permisos']);

		/*
		|--------------------------------------------------------------------------
		| GESTIÓN DE ROLES
		|--------------------------------------------------------------------------
		|
		| 
		|
		*/
		Route::resource('roles', 'RolesController');
		/*
		|--------------------------------------------------------------------------
		| GESTIÓN DE PÁGINA DE INICIO
		|--------------------------------------------------------------------------
		|
		| 
		|
		*/
	
		Route::resource('bloques', 'BloquesController');
		Route::post('buscador', ['as' => 'buscador-cupones-inicio', 'uses' => 'BloquesController@buscador_cupones']);
		Route::post('bloques/nuevo', ['as' => 'nuevo-bloque', 'uses' => 'BloquesController@nuevo_bloque']);
		Route::post('bloques/desktop-cupon-principal', ['as' => 'bloque_desktop_cupon_principal', 'uses' => 'BloquesController@bloque_desktop_cupon_principal']);
		Route::post('bloques/{id}', 'BloquesController@editar_bloques');




		//Ruta ajax para popular las subcategorias en función de la categoría seleccionada
		Route::get('/bloque/create/ajax-cat',function()
		{
		    $cat_id = Input::get('cat_id');
		    $subcategories = Subcategoria::where('categoria_id',$cat_id)->get();
		    return $subcategories;
		 
		});
		/*
		|--------------------------------------------------------------------------
		| GESTIÓN DE USUARIOS
		|--------------------------------------------------------------------------
		|
		| 
		|
		*/
		Route::resource('usuarios', 'UsersController');
		Route::get('lista-usuarios', ['as' => 'lista-usuarios', 'uses' => 'UsersController@listar_usuarios']);




		/*
		|--------------------------------------------------------------------------
		| ZONA SUPER ADMIN
		|--------------------------------------------------------------------------
		|
		| 
		|
		*/
		Route::group(['middleware' => ['admin']], function () {

			Route::get('editar-banner-cabecera', ['as' => 'banner_cabecera', 'uses' => 'BloquesController@banner_cabecera']);
			Route::post('editar-banner-cabecera', ['as' => 'banner_cabecera_edit', 'uses' => 'BloquesController@banner_cabecera_edit']);


			Route::get('editar-banner-home', ['as' => 'banner_home', 'uses' => 'BloquesController@banner_home']);
			Route::post('editar-banner-home', ['as' => 'banner_home_edit', 'uses' => 'BloquesController@banner_home_edit']);


			Route::get('custom-categorias', ['as' => 'custom_categorias', 'uses' => 'CategoriaController@custom_categorias']);
			Route::post('custom-categorias-data', ['as' => 'custom_categorias_data', 'uses' => 'CategoriaController@custom_categorias_data']);
			Route::post('custom-categorias', ['as' => 'custom_categorias_edit', 'uses' => 'CategoriaController@custom_categorias_edit']);

			Route::get('banners-menu', ['as' => 'banners_menu', 'uses' => 'BloquesController@banners_menu']);
			Route::post('banners-menu', ['as' => 'banners_menu_edit', 'uses' => 'BloquesController@banners_menu_edit']);

		});

		/*
		|--------------------------------------------------------------------------
		| SISTEMA DE PAGOS
		|--------------------------------------------------------------------------
		|
		| 
		|
		*/
		
		Route::get('confirmacion-pago/{slug}', ['as' => 'pago_promocion_confirmado', 'uses' => 'PagosController@pago_confirmado']);
		Route::post('confirmacion-pago/{slug}', ['as' => 'pago_promocion_confirmado', 'uses' => 'PagosController@pago_confirmado']);
		Route::get('pago-no-procesado/', ['as' => 'pago_promocion_denegado', 'uses' => 'PagosController@pago_cancelado']);
	});







/*
|--------------------------------------------------------------------------
| GESTIÓN DE CUPONES
|--------------------------------------------------------------------------
|
| 
|
*/
Route::resource('cupones', 'CuponesController');
Route::get('cupones/editar/{slug}', ['as' => 'editar_cupon', 'uses' => 'CuponesController@edit']);
Route::post('listar-cupones/buscar', ['as' => 'buscar-cupon', 'uses' => 'CuponesController@buscar_cupon']);
Route::post('listar-cupones/buscar-caducados', ['as' => 'buscar-caducados', 'uses' => 'CuponesController@buscar_caducados']);
Route::post('listar-cupones/buscar-programados', ['as' => 'buscar-programados', 'uses' => 'CuponesController@buscar_programados']);


/*
|--------------------------------------------------------------------------
| GESTIÓN DE PROMOCIONES
|--------------------------------------------------------------------------
|
| 
|
*/
Route::resource('promociones', 'PromocionesController');
Route::get('promociones/editar/{slug}', ['as' => 'editar_promocion', 'uses' => 'PromocionesController@edit']);
Route::post('listar-promociones/buscar', ['as' => 'buscar-promocion', 'uses' => 'PromocionesController@buscar_promocion']);
Route::post('listar-promociones/buscar-caducados', ['as' => 'buscar-caducados', 'uses' => 'PromocionesController@buscar_caducados']);
Route::post('listar-promociones/buscar-programados', ['as' => 'buscar-programados', 'uses' => 'PromocionesController@buscar_programados']);

/*
|--------------------------------------------------------------------------
| GESTIÓN DE CUPONES DE DESCUENTO
|--------------------------------------------------------------------------
|
| 
|
*/

Route::get('descuentos', ['as' => 'descuentos', 'uses' => 'CuponesController@descuentos']);
Route::get('cupon-descuento/{id}', ['as' => 'cupon-descuento', 'uses' => 'CuponesController@cupon_descuento']);
/*
|--------------------------------------------------------------------------
| GESTIÓN DE COMENTARIOS
|--------------------------------------------------------------------------
|
| 
|
*/
Route::resource('comentarios', 'ComentariosController');
Route::get('{cupon}/comentarios', ['as' => 'lista-comentarios', 'uses' => 'ComentariosController@lista_comentarios']);

/*
|--------------------------------------------------------------------------
| GESTIÓN DE CATEGORÍAS Y SUBCATEGORÍAS
|--------------------------------------------------------------------------
|
| 
|
*/
Route::resource('categorias', 'CategoriaController');
Route::resource('subcategorias', 'SubcategoriaController');
Route::get('listado-categorias', ['as' => 'listado-categorias', 'uses' => 'CategoriaController@listar_categorias']);
Route::post('nueva-categoria/{slug}', ['as' => 'update-categoria','uses' => 'CategoriaController@update']);
Route::get('categoria/{slug}/subcategorias', ['as' => 'ver-subcategorias', 'uses' => 'CategoriaController@ver_subcategorias']);
Route::post('subcategorias/{slug}', ['as' => 'crear-subcategoria', 'uses' => 'CategoriaController@crear_subcategoria']);

//Route::get('listado-subcategorias', ['as' => 'listado-subcategorias', 'uses' => 'SubcategoriaController@listar_subcategorias']);

Route::post('categorias/{categoria}/subcategorias/{subcategoria}', ['as' => 'editar-subcat', 'uses' => 'SubcategoriaController@update']);
Route::get('subcategorias/subcategoria/{slug}/borrar', 'SubcategoriaController@destroy');
Route::get('categorias/categoria/{slug}/borrar', 'CategoriaController@destroy');
  

/*
|--------------------------------------------------------------------------
| PÁGINAS DE ERROR
|--------------------------------------------------------------------------
|
| 
|
*/
//Provisional
Route::get('403', ['as' => '403',  function(){
		return view('errors.403');
	}]);


//});
