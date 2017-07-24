<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Http\Request;

use Auth;
use Config;
use Input;


use App\Models\User;
use App\Models\Tienda;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**      
    * [normalizar_string elimina acentos y caracteres extraños de un string dado]     
    * @param  [atring] $string [string a normalizar]      
    * @return $string string sin caracteres extraños ni acentos      
    */
    /*public function normalizar_string($string)
    {

       //Reemplazamos caracteres especiales latinos

        $repl = array(  'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                  	  'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                  	  'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                  	  'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
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
    }*/

    /**      
    * [subir_imagen almacena una imagen subida por el usuario]     COMPROBAR
    * @param  [string] $nombre [nombre d ela imagen]      
    * @param  [integer] $id [id del usuario que sube la imagen]      
    * @param  [string] $folder [carpeta en la que se guarda]      
    * @return string [ruta generada para la imagen]     
    */
    /*public function subir_imagen($nombre, $id, $folder)
    {
        //Verificamos si hay fichero
        if ($nombre != '') 
        {
            $file = Input::file('logo');

            //Ruta donde guardamos el fichero
            $ruta = base_path().'/public/uploads/'.$folder.'/'.$id;

            //Limpiamos nombre
            $nombre_fichero = str_replace(" ", "_", $file->getClientOriginalName());

            //Lo guardamos en la ruta que le decimos
            $subir = $file->move($ruta, $nombre_fichero);

            //Asignamos la ruta para la BD
            $ruta_url = '/uploads/'.$folder.'/'. $id . "/" . $nombre_fichero;

            return $ruta_url;                
        
        }
    } */


    /**
     * [mezclar_cupones_promociones mezclamos y sacamos 4 ofertas entre cupones y promociones]
     * @return [type] [description]
     */
    protected function mezclar_cupones_promociones(){

      //segun el dispositivos realizamo una llamada un otra
      if (identificar_dispositivo() == 'movil') {

        $data['cupones'] = $this->cuponRepo->get_cupones();
        $data['promociones'] = $this->promocionRepo->get_promociones();

      }
      else{

        $data['cupones'] = $this->cuponRepo->get_cupones_activos_num(4);
        $data['promociones'] = $this->promocionRepo->get_promociones_activas_num(4);

      }

      //juntamos los conjuntos de collecciones en una
      $juntar_array = $data['cupones']->merge($data['promociones']);

      //Ordenamos las colecciones por fecha de creación
      $juntar_array = $juntar_array->sortByDesc('created_at');

      return $juntar_array;

    }


    /**
     * Cargamos las imágenes por categorías y las mostramos en promociones y cupones
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function imagenes_por_categoria(Request $request)
    {

        $imagenes = self::imagenes_de_carpeta($request->categoria_slug, $request->url_imagenes);

        $imagenes_html = self::colocar_imagenes_en_select($imagenes, $request->categoria_slug, $request->url_imagenes, $request->imagen_marcada);

        return $imagenes_html;

    }



    /**
     * Sacamos las imágenes de una carpeta para los cupones y promociones 
     * @param  [categoria_id] [define si se quiere una categoria concreta]
     * @param  [ruta_carpeta_img] [indica a que carpeta debe entrar para recoger las imagenes]
     * @return array [array con el nombre de las imágenes]
     */
    public function imagenes_de_carpeta($categoria_slug = null,$ruta_carpeta_img = null)
    {   

        //Si no declaramos la ruta, por defecto sacamos del directorio blog
        if (is_null($ruta_carpeta_img)) {
            //Abrimos el directorio donde están las imágenes de los
            $ruta_carpeta_img = 'cupones';
        }

        if (is_null($categoria_slug)) {

            //Abrimos el directorio donde están las imágenes de los
            $directorio = opendir(carpeta_public() . '/img/' . $ruta_carpeta_img);

        }
        else{

          //Abrimos el directorio donde están las imágenes de los
          $directorio = opendir(carpeta_public() . '/img/' . $ruta_carpeta_img . '/' . $categoria_slug . '/');

        }


        //Declaramos el array que vamos a devolver con las imágenes
        $arr_imgagenes_cupones = array();

        //obtenemos un archivo y luego otro sucesivamente
        while ($archivo = readdir($directorio))
        {
            //verificamos si es o no un directorio
            if (!is_dir($archivo) && count(explode('.', $archivo)) > 1 && $archivo != '.DS_Store' && $archivo != 'thumbnail')
            {   
              $arr_imgagenes_cupones[] = $archivo;
            }
        }

        return $arr_imgagenes_cupones;
    }



    public function colocar_imagenes_en_select($imagenes, $categoria_slug, $url_imagenes, $imagen_marcada)
    {
      //Construimos el HTML
        $imagenes_html = '<select id="imagen" name="logo" class="image-picker show-html"><option value=""></option>';

        foreach ($imagenes as $imagen) {

          $value_imagen = $categoria_slug. '/' .$imagen;

          $src_imagen = asset('img/' . $url_imagenes . '/' . $value_imagen);

          if($imagen_marcada == $value_imagen)
          {
              $imagenes_html .= '<option data-img-src="' . $src_imagen . '" value="' . $value_imagen . '" selected></option>';
          }
          else{
              $imagenes_html .= '<option data-img-src="' . $src_imagen . '" value="' . $value_imagen . '"></option>';
          }
        }

        $imagenes_html .= '</select>';

        return $imagenes_html;
    }
}