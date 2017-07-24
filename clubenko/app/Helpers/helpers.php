<?php
    /**      
    * [has_permiso chequea si el usuario tiene determinado permiso]     
    * @param  [string] $permiso [permiso a verificar]      
    * @return response     
    */
    function has_permiso($permiso){
        
        if(Auth::check()){


            $array_permisos_rol = Auth::user()->role->permiso->lists('nombre')->toArray(); //añadir where disponible == 1 o algo así, con una columna, para dar la opciond e quitar

            $array_permisos_user = Auth::user()->permiso()->where('permitido', 1)->lists('nombre')->toArray();
            
            $permisos_denegados = Auth::user()->permiso()->where('permitido', 0)->lists('nombre')->toArray();

            $array_permisos = array_diff(array_merge( $array_permisos_user, $array_permisos_rol), $permisos_denegados);

            return in_array($permiso, $array_permisos);
        }
        
        return false;

    }

	function normalizar_string($string){

       //Reemplazamos caracteres especiales latinos

        $repl = array(  'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                      'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                      'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                      'ö'=>'o', 'ø'=>'o','ü'=>'u','ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
        $string = strtr( $string, $repl );

        //Ponemos todos los caracteres en minúsculas
        $string = strtolower($string);
        
        // Añadimos guiones por espacios 
        $string = str_replace (' ', '-', $string);  

        // Eliminamos y Reemplazamos demás caracteres especiales  
        $find = array('/[^a-z0-9-<>]/', '/[-]+/', '/<[^>]*>/');  
        $repl = array('', '-', '');  
        $string = preg_replace ($find, $repl, $string); 

      return $string;
    }


    function subir_imagen($nombre, $request_file, $id, $folder)
    {

        //Verificamos si hay fichero
        if ($request_file != '') 
        {   
            $file = Input::file($nombre);

            //Ruta donde guardamos el fichero
            $ruta = base_path().'/public/uploads/'.$folder.'/'.$id;

            //Si no existe la carpeta la creamos
            if (!is_dir($ruta)) {
                File::makeDirectory($ruta,0777,true);       
            }

            if ($file) {

                //Limpiamos nombre
                $nombre_fichero = str_replace(" ", "_", $file->getClientOriginalName());

                //Lo guardamos en la ruta que le decimos
                $subir = $file->move($ruta, $nombre_fichero);

            }
            elseif($request_file != 'data:,')
            {

                list($type, $request_file) = explode(';', $request_file);
                list(, $request_file)      = explode(',', $request_file);
                $request_file = base64_decode($request_file);

                //Nombre del banner
                $nombre_fichero = 'banner_home.png';

                file_put_contents($ruta . '/' . $nombre_fichero, $request_file);

            }
            else{

                return null;
            }

            //Asignamos la ruta para la BD
            $ruta_url = '/uploads/'.$folder.'/'. $id . "/" . $nombre_fichero;

            return $ruta_url;                
        
        }
    }

    function return_vistas($nombre_vista,$data)
    {
        if(BrowserDetect::isMobile()){
            return view($nombre_vista.'.movil',compact('data'));
        }

        /*if(BrowserDetect::isTablet()){
            return view($nombre_vista.'.tablet',compact('data'));
        }*/
       
        return view($nombre_vista.'.desktop',  compact('data'));
    }


    function identificar_dispositivo()
    {
        if(BrowserDetect::isMobile()){
            return 'movil';
        }


        if(BrowserDetect::isTablet()){
            return 'tablet';
        }
       
        return 'desktop';
    }


    /********
    CUPONES
    **********/


    function total_cupones_activos()
    {   
        return App\Repositories\CuponRepo::total_cupones_activos()->count();
    }



    /**
     * Pintamos las categorías del menú principal de la vista publica Desktop
     * @param  [type] $posicion_banner [description]
     * @return [type]                  [description]
     */
    function menu_categorias($inicio,$fin)
    {   
        $categorias = App\Repositories\CategoriaRepo::get_categorias();

        $count_cat = $categorias->count();

        $return = '';

        //En caso de pedir más elementos de los que existen, limitamos el for
        if ($fin > $count_cat) {
            $fin = $count_cat-1;
        }

        for ($i=$inicio; $i < $fin; $i++) { 
            $return .= '<a href="'.route('home_ver_categoria',$categorias[$i]->slug).'" class="subnav-link subnav-link-count" role="menuitem">';
            $return .= $categorias[$i]->nombre;
            $return .= '<span class="count">' . $categorias[$i]['cupones_activos']->count() . '</span>';
            $return .= '</a>';
        }

        return $return;
    }


    /**
     * Pintamos los banners del menú principal de la vista publica Desktop
     * @param  [type] $posicion_banner [description]
     * @return [type]                  [description]
     */
    function menu_banner($posicion_banner = null)
    {   
        if (is_null($posicion_banner)) {
            return '';
        }

        //Sacamos le banner
        $banner = App\Models\Bloque::where('tipo','banner_menu')->first();

        if ($banner) {
            //Verificamos que banner tenemos que devolver
            if ($posicion_banner == 1 && $banner->imagen != '') {
                $imagen = '<img class="ls-lazy" width="220" height="210" alt="ClubEnko" title="ClubEnko" src="' . asset($banner->imagen) . '" >';
            }
            elseif ($posicion_banner == 2 && $banner->imagen_dos != '') {
                $imagen = '<img class="ls-lazy" width="220" height="210" alt="ClubEnko" title="ClubEnko" src="' . asset($banner->imagen_dos) . '" >';
            }
        }
        else{
            $imagen = '';
        }
        
        return $imagen;
    }


    function get_tipo_de_objeto($modelo = null)
    {
        if (is_null($modelo)) {
            return null;
        }
        $tipo_objeto = class_basename($modelo);

        switch ($tipo_objeto) {
            case 'Cupon':
                return 1;
                break;
            case 'Tienda':
                return 2;
                break;
            default:
                # code...
                break;
        }

    }


    function es_usuario($user = null)
    {
        if (is_null($user)) {
            return false;
        }
        if ($user->rol == 1) {
            return true;
        }
        
        return false;
    }

    function es_comercio($user = null)
    {
        if (is_null($user)) {
            return false;
        }
        if ($user->rol == 2) {
            return true;
        }
        
        return false;
    }

    function es_administrador($user = null)
    {
        if (is_null($user)) {
            return false;
        }
        if ($user->rol == 3) {
            return true;
        }
            
        return false;
    }



    function dias()
    {
        return array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    }

    function meses(){
        return array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    }



    //creamos un string de los mensajes de errors para el notify
    function string_errors($errors =  null){

        $mensaje_errors = "<ul>";
            foreach ($errors->all() as $error){
                $mensaje_errors .= "<li>".html_entity_decode("$error")."</li>";
            }
        
        $mensaje_errors .= "</ul>";

        return $mensaje_errors;
    }


    /**
     * Devuelve la privincia de la dirección consultando con google
     * @param  [type] $direccion [description]
     * @return [type]            [description]
     */
    function provincia_form_direccion($direccion = null)
    {
        if (is_null($direccion)) {
            return '';
        }


        // url encode the address
        $address = urlencode($direccion);

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
          return $resp['results'][0]['address_components'][2]['long_name'];
        }
    }

    /**
     * [fecha_formato_europeo convertir una fecha de SQL a formato europeo]
     * @param  [string] $fecha [fecha SQL]
     * @return [string]        [fecha formato europeo]
     */
    function fecha_formato_europeo($fecha = null)
    {
        if ($fecha) {
            $arr = explode('-',$fecha);

            if (count($arr) == '3') {
                return $arr[2] . '/' . $arr[1] . '/' . $arr[0];
            }
        }
        return '';

    }

    /**
     * [carpeta_public Lleva hasta la carpeta pública httpdocs/publicMedssocial]
     * @return [type] [description]
     */
    function carpeta_public()
    {
        return base_path() . '/public';
    }

?>