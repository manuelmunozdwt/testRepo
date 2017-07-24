<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Repositories\TiendaRepo;
use App\Repositories\CuponRepo;
use App\Repositories\ComentarioRepo;
use App\Repositories\UserRepo;
use App\Repositories\CategoriaRepo;
use App\Repositories\SubcategoriaRepo;
use App\Repositories\PromocionRepo;

class ValidacionesController extends Controller
{
 	
 	public function __construct(TiendaRepo $tiendaRepo,
 								CuponRepo $cuponRepo,
                                ComentarioRepo $comentarioRepo,
                                UserRepo $userRepo,
                                CategoriaRepo $categoriaRepo,
                                SubcategoriaRepo $subcategoriaRepo,
                                PromocionRepo $promocionRepo)
 	{
 		$this->tiendaRepo = $tiendaRepo;
 		$this->cuponRepo = $cuponRepo;
        $this->comentarioRepo = $comentarioRepo;
        $this->userRepo = $userRepo;
        $this->categoriaRepo = $categoriaRepo;
        $this->subcategoriaRepo = $subcategoriaRepo;
        $this->promocionRepo = $promocionRepo;
 	}

    
    /**
     * Llama a validar() para una determinada tienda si el usuario logado tiene permiso
     * @param  [string] [datos de la tienda]
     * @return view [vuelve a la lista de tiendas]
     */
    public function validar_tienda($slug){	
    	if(!has_permiso('Validar tiendas')){
    		return view('errors.403');
    	}
        $tienda = $this->tiendaRepo->datos_tienda($slug);
        $tienda = $this->validar($tienda);

        return redirect()->back()->withErrors('Tienda validada correctamente');

    }
    
    /**
     * Llama a validar() para un determinado cupón si el usuario logado tiene permiso
     * @param  [string] [slug del cupón]
     * @return view [vuelve a la lista de cupones]
     */
    public function validar_cupon($slug){
    	if(!has_permiso('Validar cupones')){
    		return view('errors.403');
    	}   

        $cupon = $this->cuponRepo->get_datos_cupon($slug);
        
        $cupon = $this->validar($cupon);

        return redirect()->back()->withErrors('Cupón validado correctamente');
  
    }
    
    /**
     * Llama a validar() para un determinado cupón si el usuario logado tiene permiso
     * @param  [string] [slug del cupón]
     * @return view [vuelve a la lista de cupones]
     */
    public function validar_comentarios($id){

        $comentario = $this->comentarioRepo->comentario($id);
        $comentario = $this->validar($comentario);
        return redirect()->route('comentarios.index')->withErrors('Comentario validado correctamente');

    }
    /**
     * Llama a validar() para un determinado cupón si el usuario logado tiene permiso
     * @param  [string] [slug del cupón]
     * @return view [vuelve a la lista de cupones]
     */
    public function validar_usuarios($id){

        $usuario = $this->userRepo->usuario($id);
        $usuario = $this->validar($usuario);
        return redirect()->back()->withErrors('Usuario validado correctamente');

    }

    /**
     * Llama a validar() para una determinada categoria si el usuario logado tiene permiso
     * @param  [string] [datos de la categoria]
     * @return view [vuelve a la lista de categorias]
     */
    public function validar_categoria($slug){  
        if(!has_permiso('Validar categorías')){
            return view('errors.403');
        }
        $categoria = $this->categoriaRepo->datos_categoria($slug);
        $categoria = $this->validar($categoria);
        return redirect()->back()->withErrors('Categoría validada correctamente');

    }

    /**
     * Llama a validar() para una determinada subcategoria si el usuario logado tiene permiso
     * @param  [string] [datos de la categoria]
     * @return view [vuelve a la lista de subcategorias]
     */
    public function validar_subcategoria($slug){  
        if(!has_permiso('Validar subcategorías')){
            return view('errors.403');
        }
        $subcategoria = $this->subcategoriaRepo->datos_subcategoria($slug);
        $subcategoria = $this->validar($subcategoria);
        return redirect()->back()->withErrors('Sub-Categoría validada correctamente');

    }

    /**
     * Llama a validar() para una determinada subcategoria si el usuario logado tiene permiso
     * @param  [string] [datos de la categoria]
     * @return view [vuelve a la lista de subcategorias]
     */
    public function validar_promocion($slug){  
        if(!has_permiso('Validar promociones')){
            return view('errors.403');
        }
        $subcategoria = $this->promocionRepo->get_datos_promocion($slug);
        $subcategoria = $this->validar($subcategoria);
        return redirect()->back()->withErrors('Promoción validada correctamente');

    }

    /**
     * Valida o invalida un determinado objeto, cambiando el estado "confirmado" de la base de datos
     * @param  [objeto] [objeto a validar]
     * @return boolean 
     */
    public function validar($objeto){
		if($objeto->confirmado == 0){
			$objeto->confirmado = 1;
        }
    	return $objeto->save();
    }
}
