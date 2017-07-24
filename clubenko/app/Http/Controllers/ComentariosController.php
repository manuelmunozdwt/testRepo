<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Comentario;

use App\Repositories\ComentarioRepo;
use App\Repositories\CuponRepo;
use Auth;

use App\Http\Requests;

class ComentariosController extends Controller
{
    public function __construct(ComentarioRepo $comentarioRepo,
    							CuponRepo $cuponRepo)
    {
    	$this->comentarioRepo = $comentarioRepo;
    	$this->cuponRepo = $cuponRepo;
    }

	public function index(){
		if(!has_permiso('Ver lista comentarios')){
			return view('errors.403');
		}
        
        $data['comentarios'] = $this->comentarioRepo->comentarios_por_validar();

        return view('dashboard.validaciones.lista-comentarios', compact('data'));

  	}

	public function create(){

	}

	public function store(Request $request){
		if(!has_permiso('Crear comentario')){
			return view('errors.403');
		}

		$messages = [
			'comentario.max' => 'El comentario no puede tener más de 200 caracteres.'
		];

        $validator = Validator::make($request->all(), [
            'comentario' => 'max:200',
        ], $messages);

        if ($validator->fails()) {
            return redirect()
            		->back()
                    ->withErrors($validator)
                    ->withInput();
        }

		$comentario = new Comentario();

		$comentario->comentario = $request->comentario;
		$comentario->user_id = Auth::user()->id;
		$comentario->cupon_id = $request->cupon_id;

		$comentario_existe = $this->comentarioRepo->get_comentario(Auth::user()->id, $request->cupon_id);
		//dd(!empty($comentario_existe));
		if(!empty($comentario_existe)){
			return redirect()->back()->with('status', 'Ya has enviado un comentario en este cupón. Muchas gracias.');
		}else{
			$comentario->save();

			return redirect()->back()->with('status', 'Muchas gracias por dejarnos tu comentario.');;
		}
	}

	public function show(){
	}

	public function edit($id){
		if(!has_permiso('Editar comentario')){
			return view('errors.403');
		}

		$data['comentario'] = $this->comentarioRepo->comentario($id);

		return view('comentarios.editar-comentario', compact('data'));

	}

	public function update($id, Request $request){
		if(!has_permiso('Editar comentario')){
			return view('errors.403');
		}

		$data['comentario'] = $this->comentarioRepo->comentario($id);

		$data['comentario']->comentario = $request->comentario;
		$data['comentario']->save();
        $data['comentarios'] = $this->comentarioRepo->comentarios_por_validar();

        return redirect()->route('comentarios.index')->with('status', 'Comentario editado correctamente');

	}

	public function destroy($id){
		if(!has_permiso('Borrar comentario')){
			return view('errors.403');
		}

		$comentario = $this->comentarioRepo->comentario($id);

		$comentario->delete();

		return redirect()->route('comentarios.index')->with('status', 'Comentario eliminado correctamente');
	}

	public function lista_comentarios($slug){

		$data['cupon'] = $this->cuponRepo->get_datos_cupon($slug);
        

        $data['comentarios'] = $this->comentarioRepo->get_comentarios_cupon($data['cupon']->id);
        
        if(Auth::check()){
            $comentario_existe = $this->comentarioRepo->get_comentario(Auth::user()->id, $data['cupon']->id);
        }else{
            $comentario_existe = null;
        }

        return view('comentarios.comentarios', compact('data', 'comentario_existe'));

  	}



  	public function get_fecha_bonita_comentario($comentarios = null)
  	{
  		if (is_null($comentarios)) {
  			return $comentarios;
  		}

  		foreach ($comentarios as $comentario) {

  			if (is_null($comentario->created_at)) {
  				$comentario->fecha_bonita = '';
  			}
  			else{

  				$fecha_bonita = date(strtotime($comentario->created_at));

				 
				$fecha_bonita = dias()[date('w',$fecha_bonita)]." ".date('d',$fecha_bonita)." de ".meses()[date('n',$fecha_bonita)-1]. " del ".date('Y',$fecha_bonita) ;
				//Salida: Viernes 24 de Febrero del 2012
  				
  				$comentario->fecha_bonita = $fecha_bonita;

  			}
  		
  		}

  		return $comentarios;
  	}

  	
}
