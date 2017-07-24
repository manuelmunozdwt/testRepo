<?php

namespace App\Http\Controllers;

use App\Repositories\LikeObjetoRepo;
use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Models\Cupon;
use App\Models\LikeObjeto;

class LikeController extends Controller
{

	protected $likeObjetoRepo;

    public function __construct(LikeObjetoRepo $likeObjetoRepo)
    {
        $this->likeObjetoRepo = $likeObjetoRepo;
    }



    /**
     * Controla los megusta de los objetos
     * @param  [int] $tipo_objeto [description]
     * @param  [int] $objeto_id   [description]
     * @return [type]              [description]
     */
    public function like(Request $request)
    {
        if($request->ajax()){

            $arr_datos_cont = array();

            $inputs= $request->input();

            //Colocamos la key con lso datos en el objeto
            foreach ($inputs as $key => $value) {
            	$objeto = $key;
            }

            //btn_{{Config::get('constantes.anuncio')}}_{{$objetos[$i]->id}}
            $objeto = explode('_', $objeto);

            //Vemos si el usuario ha puesto el like en el objeto
            if(!self::comprobar_like($objeto[2], $objeto[1])) {

            $likes = new LikeObjeto;
            $likes->user_id = Auth::id();
            $likes->tipo_id = $objeto[1];
            $likes->objeto = $objeto[2];

            $likes->save();

            //true o false para cambiar el icono del like
            $arr_datos_cont[3] = true;
            }
            else {
            $this->borrar_like($objeto[2], $objeto[1]);
            //true o false para cambiar el icono del like
            $arr_datos_cont[3] = false;
            }

            //ID del anuncio
            $arr_datos_cont[0] = $objeto[2];

            //numero de likes 
            $arr_datos_cont[1] = $this->contar_like($objeto[2], $objeto[1]);

            //tipo del objetoi
            $arr_datos_cont[2] = $objeto[1];

            return $arr_datos_cont;
        
        }
    }



	/**
	* Con esta funcion, preparamos los corazones de like sobre los objetos que lo lleven.
	* @param  [int] $objeto_id   [ID del objeto]
	* @param  [int] $tipo_objeto [ID del tipo de objeto]
	* @return [objeto]  $objetos [Devuelve el objeto de objetos]
	*/
	public function poner_corazones_like($objetos, $tipo_objeto)
	{ 

	if(count($objetos) != 0) {
		if (is_array($objetos)) {
			foreach ($objetos as $objeto) {
			    //Verificamos si el usuario ha hecho like en alguno de los objetos
			    $objeto->tiene_like = $this->comprobar_like($objeto->id, $tipo_objeto);

			    //Miramos cuantos likes tiene cada objeto
			    $objeto->likes = $this->contar_like($objeto->id, $tipo_objeto);

			    //Colocamos el tipo de objeto que es 
			    $objeto->tipo_objeto = $tipo_objeto;

			}
		}
		else
		{
			$objetos->tiene_like = $this->comprobar_like($objetos->id, $tipo_objeto);

		    //Miramos cuantos likes tiene cada objeto
		    $objetos->likes = $this->contar_like($objetos->id, $tipo_objeto);

		    //Colocamos el tipo de objeto que es 
		    $objetos->tipo_objeto = $tipo_objeto;
		}
	  
	}

	return $objetos; 
	}


	    /**
	     * Verificamos si el usuario tiene like en ese objeto
	     * @param  [int]     $objeto_id      [ID del objeto]
	     * @param  [int]     $id_tipo_objeto [tipo del objeto]
	     * @param  LikeObjeto $likeObjetoRepo [repositorio del Modelo Like]
	     * @return [boolean]                     [indica si hay o no coincidencias]
	     */
	    public function comprobar_like($objeto_id, $id_tipo_objeto)
	    {

	      $like_objeto = $this->likeObjetoRepo->comprobarLike($objeto_id, $id_tipo_objeto,Auth::id());

	      if (count($like_objeto) == 0) 
	        return false;

	      return true;
	    }



	    /**
	     * Contamos el numero total de likes de un objeto
	     * @param  [int]     $objeto_id      [ID del objeto]
	     * @param  [int]     $id_tipo_objeto [tipo del objeto]
	     * @param  LikeObjeto $likeObjetoRepo [repositorio del Modelo Like]
	     * @return [int]                     [numero de likes]
	     */
	    public function contar_like($objeto_id, $id_tipo_objeto)
	    {

	      $numero_likes = $this->likeObjetoRepo->contarLike($objeto_id, $id_tipo_objeto); 

	      return count($numero_likes);
	    }


	    /**
	     * Borramos el like del objeto
	     * @param  [int]     $objeto_id      [ID del objeto]
	     * @param  [int]     $id_tipo_objeto [tipo del objeto]
	     * @param  LikeObjeto $likeObjetoRepo [repositorio del Modelo Like]
	     * @return []                     []
	     */
	    public function borrar_like($objeto_id, $id_tipo_objeto)
	    { 
	      $this->likeObjetoRepo->borrarLike($objeto_id, $id_tipo_objeto,Auth::id());
	    }

}