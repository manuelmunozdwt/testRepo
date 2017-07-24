<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\TiendaRequest;
use App\Http\Requests\Api\ImagenRequest;
use App\Repositories\TiendaRepo;
use App\Repositories\CuponRepo;
use App\Repositories\PromocionRepo;
use App\Transformers\TiendasTransformer;
use App\Transformers\CuponesTransformer;
use App\Transformers\PromocionesTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TiendasController extends BaseController
{
    
    public function __construct(TiendaRepo $tiendaRepo, CuponRepo $cuponRepo, PromocionRepo $promocionRepo)
    {
        parent::__construct();
        $this->tiendaRepo = $tiendaRepo;
        $this->cuponRepo = $cuponRepo;
        $this->promocionRepo = $promocionRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = $this->tiendaRepo->get_todas();
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->paginator($data, new TiendasTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TiendaRequest $request)
    {
        try{
            $requestData = $this->modifyRequestData($request);
            $data = $this->tiendaRepo->crear_tienda($requestData);

            //relaciones con otras entidades
            $data->usuario()->attach($requestData['user_id']);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->item($data, new TiendasTransformer)->statusCode('201');
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
            $data = $this->tiendaRepo->get_tienda($id);
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

        return $this->response->item($data, new TiendasTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TiendaRequest $request, $id)
    {
        if (!is_numeric($id)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $requestData = $this->modifyRequestData($request);

            $data = $this->tiendaRepo->get_tienda($id);
            
            if (!$data) {
                throw new NotFoundHttpException();
            }

            $data->nombre = $requestData['nombre'];
            $data->logo = $requestData['logo'];
            $data->direccion = $requestData['direccion'];
            $data->telefono = $requestData['telefono'];
            $data->web = $requestData['web'];
            $data->latitud = $requestData['latitud'];
            $data->longitud = $requestData['longitud'];
            $data->provincia_id = $requestData['provincia_id'];
            $data->slug = $requestData['slug'];
            $data->save();

        }catch (NotFoundHttpException $exception) {
            
            return $this->response->error('Recurso no existente', 404);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }
        return $this->response->item($data, new TiendasTransformer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!is_numeric($id)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $data = $this->tiendaRepo->get_tienda($id);
            
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

    public function imagen(ImagenRequest $request, $id)
    {
        $data = null;
        try{
            $data = $this->tiendaRepo->get_tienda($id);
            $response = $this->subirImagen($request, $id, $data);
        }catch(\Exception $exception){
            throw new BadRequestHttpException('Error al subir la imágen.');
        }finally{
            if(!is_numeric($id)) {
                throw new BadRequestHttpException('El parámetro debe ser numérico.');
            }
            if(!$data){
                throw new NotFoundHttpException('Recurso no existente.');
            }
        }

        return $response;
    }

    /**
     * Restore the specified resource softdeleted.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if(!is_numeric($id)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $data = $this->tiendaRepo->get_tienda_deleted($id);
            
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cupones($id_tienda)
    {
        if(!is_numeric($id_tienda)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $data = $this->cuponRepo->cupones_por_tienda($id_tienda);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->paginator($data, new CuponesTransformer);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function promociones($id_tienda)
    {
        if(!is_numeric($id_tienda)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $data = $this->promocionRepo->promociones_por_tienda($id_tienda);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->paginator($data, new PromocionesTransformer);
    }
    
    public function modifyRequestData($request)
    {
        $requestData = $request->intersect('');

        $requestData['slug'] = $this->construir_slug($requestData['nombre'], new \App\Models\Tienda);

        //Confirmado por default para lo que viene por API
        $requestData['confirmado'] = true;

        return $requestData;
    }
}
