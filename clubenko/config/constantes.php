<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Nombre de la pagina
	|--------------------------------------------------------------------------
	|
	| Definimos el titulo para todas las paginas y el nomnre del cliente
	| que podremos utulizar en otro sitios
	|
	*/

    'cliente' => 'Club Enko',
    'pantone' => '#f50808',
    'email_cliente' => '',
    'plataforma' => '',
    'logo' => 'logo-enkoteam.png',
    'logo_secundario' => '',


    /*
	|--------------------------------------------------------------------------
	| Nombre de las bases de datos Produccion
	|--------------------------------------------------------------------------
	|
	| Sobre estos nombres va a actuar el fichero database.php para accer a las 
	| distintas bases de datos de la aplicacion. Tambien lo usarn algunos 
	| modelos
	|
	*/

	// BASE DE DATOS DEL BACKEND DE PRODUCION



	/*
	|--------------------------------------------------------------------------
	| Constantes para las url´s de los Recursos de la API 
	|--------------------------------------------------------------------------
	|
	| Estas rutas las utiliza solo para local
	|
	*/

    'ruta_img' => config('app.url').'/',



	/*
	|--------------------------------------------------------------------------
	| Roles de usuario
	|--------------------------------------------------------------------------
	|
	| Aqui definimos los roles de los usuarios de la aplicación
	|
	*/

    'rol_super_administrador' => 'superadmin',
    'rol_administrador' => 'administrador',
    'rol_tienda' => 'tienda',
  	'rol_usuario' => 'usuario',
  	
    'rol_desarrollo' => 'desarrollo',
    'rol_api' => 'api',






    /*
	|--------------------------------------------------------------------------
	| Tipos de Objetos de la aplicación
	|--------------------------------------------------------------------------
	|
	| Aqui definimos los IDs de los objetos que manejamos en la aplicacion.
	|
	*/



    /*
	|--------------------------------------------------------------------------
	| URL TRABAJO API 
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/





	/*
	|--------------------------------------------------------------------------
	| Rutas dentro de la plicacion
	|--------------------------------------------------------------------------
	|
	| Tenoms las rutas para acceder a distintos puntos de la aplicación
	|
	*/

    /*'ruta_ficheros_usuarios' => Config::get('app.url').'uploads/usuarios/',
    'ruta_img' => Config::get('app.url').'assets/img/',
    'url_blog' => '',*/




    /*
	|--------------------------------------------------------------------------
	| Email de reporte
	|--------------------------------------------------------------------------
	|
	| En este email se enviaran los reportes de errores y demas notificaciones
	| de la aplicacón
	|
	*/

    'error_email' => '',
    'error_email_name' => '',

    /*
	|--------------------------------------------------------------------------
	| Tamaño Imagenes
	|--------------------------------------------------------------------------
	|
	| Aquí definimos el tamaño que van a tener las imágenes que se suben en el sistema.
	|
	*/

    'max_size' => '4000000', //4 MB

    'mensaje_max_size' => ' es demasiado grande. El tamaño máximo aceptado es de 4 Mb', //1 Gb


    'api_key_google' => 'AIzaSyBHfPdsvLKzM7tDgYpK7JRUyR8yVnwvYCE',




];
