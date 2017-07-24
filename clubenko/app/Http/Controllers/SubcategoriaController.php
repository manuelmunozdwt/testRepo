<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SubcategoriaRequest;
use App\Models\Categoria;
use App\Models\Subcategoria;

use App\Repositories\SubcategoriaRepo;
use App\Repositories\CategoriaRepo;
use Auth;

class SubcategoriaController extends Controller
{
    public function __construct(SubcategoriaRepo $subcategoriaRepo,
                                CategoriaRepo $categoriaRepo)
    {
        $this->subcategoriaRepo = $subcategoriaRepo;
        $this->categoriaRepo = $categoriaRepo;
    }

    public function index(){
        if(!has_permiso('Ver lista categorías')){
            return view('errors.403');
        }
        $data['subcategorias'] = $this->subcategoriaRepo->subcategorias_por_validar();

        return view('dashboard.validaciones.listado-subcategorias', compact('data'));

    }

    public function create(){

    }

    public function store(SubcategoriaRequest $request){
        if(!has_permiso('Crear subcategoría')){
            return view('errors.403');
        }

        $categoria = $this->categoriaRepo->get_categoria_id($request->categoria_id)->nombre;
        $subcategoria = new Subcategoria();

        $subcategoria->nombre = $request->nombre;
        if($request->nombre == 'Otros'){   
            $subcategoria->slug = normalizar_string($request->nombre.'-'.$categoria);
        }else{
            $subcategoria->slug = normalizar_string($request->nombre);
        }
        //dd($subcategoria->slug);
        $subcategoria->categoria_id = $request->categoria_id;

        if($subcategoria->save()){
            return redirect()->back()->with('status', 'Enhorabuena, ha creado una subcategoría. La subcategoría '.$subcategoria->nombre.' está ahora pendiente de validación.');
        }else{
             return redirect()->back()->with('status', 'Ha ocurrido algún error. Por favor, revise los campos.');
   
        }
    }

    public function show(){

    }

    public function edit(){

    }


    public function update($cat, $subcat, SubcategoriaRequest $request){
        $cat_id = $this->categoriaRepo->datos_categoria($cat)->id;
        $subcategoria = $this->subcategoriaRepo->get_datos_subcategoria($cat_id, $subcat);
        
        if($subcategoria->estandar == 1){
            if(!has_permiso('Editar subcategoría estándar')){
                return view('errors.403');
            }
        }else{
            if(!has_permiso('Editar subcategoría')){
                return view('errors.403');
            }           
        } 

//dd($subcategoria->id);
        $subcategoria->nombre = $request->nombre;
        if($subcategoria->save()){
            return redirect()->back()->with('status', 'La subcategoría '.$subcategoria->nombre.' ha sido editada correctamente.');
        }else{
            return redirect()->back()->with('status', 'Ha ocurrido algún error. Por favor, revise los campos.');

        }
    }

    public function destroy($slug){

        $subcategoria = $this->subcategoriaRepo->datos_subcategoria($slug);

        if($subcategoria->estandar == 1){
            if(!has_permiso('Borrar subcategoría estándar')){
                return view('errors.403');
            }
        }else{
            if(!has_permiso('Borrar subcategoría')){
                return view('errors.403');
            }           
        }

        $subcategoria->delete();

        if(Auth::user()->rol == 3){
            return redirect()->route('subcategorias.index')->with('status', 'Subcategoría eliminada correctamente');  
        }else{
            return redirect()->route('categorias.create')->with('status', 'Subcategoría eliminada correctamente');   
        }

    }

    public function listar_subcategorias(){

    }

}
