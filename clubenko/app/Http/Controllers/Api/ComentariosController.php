<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ComentarioRequest;
use App\Repositories\ComentarioRepo;
use Illuminate\Http\Request;
use App\Transformers\ComentariosTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ComentariosController extends BaseController
{
    public function __construct(ComentarioRepo $comentarioRepo)
    {
        parent::__construct();
        $this->comentarioRepo = $comentarioRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = $this->comentarioRepo->comentarios_por_validar();
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->paginator($data, new ComentariosTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComentarioRequest $request)
    {
        try{
            $requestData = $this->modifyRequestData($request);
            //var_dump($requestData);die;
            $data = $this->comentarioRepo->crear_comentario($requestData);
            

            //relaciones con otras entidades
            //$data->usuario()->attach($requestData['user_id']);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.'.$exception, 404);
        }

        return $this->response->item($data, new ComentariosTransformer)->statusCode('201');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = null;
        try{
            $data = $this->comentarioRepo->get_comentario_id($id);
        }catch (\Exception $exception){            
            throw new BadRequestHttpException('Error en la petición.');
        }finally{
            if(!is_numeric($id)){
                throw new BadRequestHttpException('El parámetro debe ser numérico.');
            }
            if(!$data){
                throw new NotFoundHttpException('Recurso no existente.');
            }
        }

        return $this->response->item($data, new ComentariosTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComentarioRequest $request, $id)
    {
        if (!is_numeric($id)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $requestData = $this->modifyRequestData($request);

            $data = $this->comentarioRepo->get_comentario_id($id);
            
            if (!$data) {
                throw new NotFoundHttpException();
            }

            $data->comentario = $requestData['comentario'];
            $data->cupon_id = $requestData['cupon_id'];
            $data->save();

        }catch (NotFoundHttpException $exception) {
            
            return $this->response->error('Recurso no existente', 404);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.'.$exception, 404);
        }

        return $this->response->item($data, new ComentariosTransformer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!is_numeric($id)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $data = $this->comentarioRepo->get_comentario_id($id);
            
            if (!$data) {
                throw new NotFoundHttpException();
            }
            
            $data->delete();
        }catch (NotFoundHttpException $exception) {
            return $this->response->error('Recurso no existente', 404);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->noContent();
    }
    
    public function modifyRequestData($request)
    {
        $requestData = $request->intersect('');

        //Confirmado por default para lo que viene por API
        $requestData['confirmado'] = true;

        return $requestData;
    }
}
