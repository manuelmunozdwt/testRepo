<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function($api) {
    //recursos
    $api->resource('cupones', 'App\Http\Controllers\Api\CuponesController');
    $api->resource('promociones', 'App\Http\Controllers\Api\PromocionesController');
    $api->resource('usuarios', 'App\Http\Controllers\Api\UsersController');
    $api->resource('tiendas', 'App\Http\Controllers\Api\TiendasController');
    $api->resource('comentarios', 'App\Http\Controllers\Api\ComentariosController');

    //recursos no editables
    $api->get('categorias', 'App\Http\Controllers\Api\CategoriasController@index');
    $api->get('categorias/{id}', 'App\Http\Controllers\Api\CategoriasController@show');
    $api->get('subcategorias', 'App\Http\Controllers\Api\SubcategoriasController@index');
    $api->get('subcategorias/{id}', 'App\Http\Controllers\Api\SubcategoriasController@show');
    $api->get('provincias', 'App\Http\Controllers\Api\ProvinciasController@index');
    $api->get('provincias/{id}', 'App\Http\Controllers\Api\ProvinciasController@show');

    //modificando propiedades
    $api->put('cupones/{id}/restore', 'App\Http\Controllers\Api\CuponesController@restore');
    $api->put('promociones/{id}/restore', 'App\Http\Controllers\Api\PromocionesController@restore');
    $api->put('usuarios/{id}/restore', 'App\Http\Controllers\Api\UsersController@restore');
    $api->post('usuarios/{id}/imagen', 'App\Http\Controllers\Api\UsersController@imagen');
    $api->post('tiendas/{id}/imagen', 'App\Http\Controllers\Api\TiendasController@imagen');
    $api->put('tiendas/{id}/restore', 'App\Http\Controllers\Api\TiendasController@restore');

    //relacionados
    $api->get('cupones/{id}/comentarios', 'App\Http\Controllers\Api\CuponesController@comentarios');
    $api->get('usuarios/{id}/tiendas', 'App\Http\Controllers\Api\UsersController@tiendas');
    $api->get('usuarios/{id}/comentarios', 'App\Http\Controllers\Api\UsersController@comentarios');
    $api->get('tiendas/{id}/cupones', 'App\Http\Controllers\Api\TiendasController@cupones');
    $api->get('tiendas/{id}/promociones', 'App\Http\Controllers\Api\TiendasController@promociones');
    $api->get('categorias/{id}/cupones', 'App\Http\Controllers\Api\CategoriasController@cupones');
    $api->get('categorias/{id}/promociones', 'App\Http\Controllers\Api\CategoriasController@promociones');
    $api->get('categorias/{id}/imagenes', 'App\Http\Controllers\Api\CategoriasController@imagenes');
    $api->get('subcategorias/{id}/cupones', 'App\Http\Controllers\Api\SubcategoriasController@cupones');
    $api->get('subcategorias/{id}/promociones', 'App\Http\Controllers\Api\SubcategoriasController@promociones');
    $api->get('provincias/{id}/tiendas', 'App\Http\Controllers\Api\ProvinciasController@tiendas');
});
