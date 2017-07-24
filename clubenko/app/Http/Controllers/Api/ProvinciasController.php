<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ProvinciaRepo;
use App\Repositories\TiendaRepo;
use App\Transformers\ProvinciasTransformer;
use App\Transformers\TiendasTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProvinciasController extends BaseController
{

    public function __construct(ProvinciaRepo $provinciaRepo, TiendaRepo $tiendaRepo)
    {
        parent::__construct();
        $this->provinciaRepo = $provinciaRepo;
        $this->tiendaRepo = $tiendaRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = $this->provinciaRepo->get_todas();
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->collection($data, new ProvinciasTransformer);
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
            $data = $this->provinciaRepo->get_provincia($id);
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
        return $this->response->item($data, new ProvinciasTransformer());
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tiendas($id_provincia)
    {
        if (!is_numeric($id_provincia)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $data = $this->tiendaRepo->tiendas_provincia($id_provincia);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->paginator($data, new TiendasTransformer);
    }

}
