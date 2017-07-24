<?php

namespace App\Http\Controllers\Api;

use App\Repositories\CuponRepo;
use App\Repositories\ComentarioRepo;
use App\Transformers\CuponesTransformer;
use App\Transformers\ComentariosTransformer;

use App\Http\Requests\Api\CuponRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CuponesController extends BaseController
{

    public function __construct(CuponRepo $cuponRepo, ComentarioRepo $comentarioRepo)
    {
        parent::__construct();
        $this->cuponRepo = $cuponRepo;
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
            $data = $this->cuponRepo->get_todas();
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->paginator($data, new CuponesTransformer);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CuponRequest $request)
    {
       
        try{
            $requestData = $this->modifyRequestData($request);

            $data = $this->cuponRepo->crear_cupon($requestData);

            //asociamos el cupon a las tiendas elegidas
            if(isset($requestData['tienda'])){
                foreach($requestData['tienda'] as $tienda){
                    $data->tienda()->attach($tienda);
                }
            }

            //asociamos el cupon al usuario que lo ha creado
            $data->user()->attach($requestData['user_id']);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->item($data, new CuponesTransformer)->statusCode('201');
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
            $data = $this->cuponRepo->find_cupon_id_publicado($id);
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
        return $this->response->item($data, new CuponesTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CuponRequest $request, $id)
    {
        
        if(!is_numeric($id)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            
            $requestData = $this->modifyRequestData($request);

            $data = $this->cuponRepo->get_cupon($id);
            
            if(!$data){
                throw new NotFoundHttpException();
            }

            
            $data->titulo = $requestData['titulo'];
            $data->descripcion = $requestData['descripcion'];
            $data->descripcion_corta = $requestData['descripcion_corta'];
            $data->fecha_inicio = $requestData['fecha_inicio'];
            $data->fecha_fin = $requestData['fecha_fin'];
            $data->categoria_id = $requestData['categoria_id'];
            $data->subcategoria_id = $requestData['subcategoria_id'];
            $data->filtro_id = $requestData['filtro_id'];
            $data->logo = $requestData['logo'];
            $data->slug = $requestData['slug'];
            $data->confirmado = $requestData['confirmado'];
            $data->save();
            
            //$user = $this->userRepo->usuario($requestData['user_id']);

            //asociamos el cupon a las tiendas del usuario
            $data->tienda()->detach();

            foreach($requestData['tienda'] as $tienda){
                $data->tienda()->attach($tienda);
            }

        }catch(NotFoundHttpException $exception){
            return $this->response->error('Recurso no existente', 404);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }
        return $this->response->item($data, new CuponesTransformer);
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
            $data = $this->cuponRepo->get_cupon($id);
            
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
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comentarios($id_cupon)
    {
        if (!is_numeric($id)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $data = $this->comentarioRepo->comentarios_por_usuario($id_cupon);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->paginator($data, new ComentariosTransformer);
    }
    
    /**
     * Restore the specified resource softdeleted.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!is_numeric($id)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $data = $this->cuponRepo->get_cupon_deleted($id);
            
            if (!$data) {
                throw new NotFoundHttpException();
            }
            
            $data->restore();
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
        
        //si se ha marcado ilimitado para la fecha fin marcamos la fecha maxima posible
        if(isset($requestData['ilimitado']) && $requestData['ilimitado']){
            $requestData['fecha_fin'] = '9999-12-31';
        }

        //definimos el slug del cupon
        $requestData['slug'] = $this->construir_slug($requestData['titulo'],new \App\Models\Cupon);

        //definimos la imagen del cupon
        $requestData['imagen'] = $requestData['logo'];

        //si no se ha elegido una subcategoria, guardamos null
        if(!isset($requestData['subcategoria_id']) || $requestData['subcategoria_id'] == ''){
            $requestData['subcategoria_id'] = null;
        }else{
            $requestData['subcategoria_id'] = $requestData['subcategoria_id'];
        }
        
        //confirmado por defecto
        $requestData['confirmado'] = true;

        return $requestData;
    }
}
