<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\PromocionRequest;
use App\Repositories\PromocionRepo;
use App\Transformers\PromocionesTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PromocionesController extends BaseController
{
    public function __construct(PromocionRepo $promocionRepo)
    {
        parent::__construct();
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
            $data = $this->promocionRepo->get_todas();
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->paginator($data, new PromocionesTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromocionRequest $request)
    {
        
        try{
            $requestData = $this->modifyRequestData($request);

            $data = $this->promocionRepo->crear_promocion($requestData);

            //relaciones con otras entidades
            if(isset($requestData['tienda'])){
                foreach($requestData['tienda'] as $tienda){
                    $data->tienda()->attach($tienda);
                }
            }

            $data->user()->attach($requestData['user_id']);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->item($data, new PromocionesTransformer)->statusCode('201');
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
            $data = $this->promocionRepo->find_promocion_id_publicado($id);
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

        return $this->response->item($data, new PromocionesTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PromocionRequest $request, $id)
    {

        if (!is_numeric($id)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $requestData = $this->modifyRequestData($request);

            $data = $this->promocionRepo->get_promocion($id);
            
            if (!$data) {
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
            $data->precio = $requestData['precio'];
            $data->precio_descuento = $requestData['precio_descuento'];
            $data->logo = $requestData['logo'];
            $data->slug = $requestData['slug'];
            $data->confirmado = $requestData['confirmado'];
            $data->save();

            //relaciones con otras entidades
            $data->tienda()->detach();
            foreach($requestData['tienda'] as $tienda){
                $data->tienda()->attach($tienda);
            }
        }catch (NotFoundHttpException $exception) {
            return $this->response->error('Recurso no existente', 404);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }
        return $this->response->item($data, new PromocionesTransformer);
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
            $data = $this->promocionRepo->get_promocion($id);
            
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
            $data = $this->promocionRepo->get_promocion_deleted($id);
            
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

        $requestData['precio_descuento'] = $this->getPrecioConDescuento($requestData['precio'], $requestData['filtro_id']);

        //si se ha marcado ilimitado para la fecha fin marcamos la fecha maxima posible
        if(isset($requestData['ilimitado']) && $requestData['ilimitado']){
            $requestData['fecha_fin'] = '9999-12-31';
        }

        if($requestData['tipo_promocion'] == 'reserva'){
            $requestData['reserva']  = true;
        }

        //definimos el slug del promocion
        $requestData['slug'] = $this->construir_slug($requestData['titulo'],new \App\Models\Promocion);

        //definimos la imagen del promocion
        $requestData['imagen'] = $requestData['logo'];

        //si no se ha elegido una subcaregoria, guardamos null
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
