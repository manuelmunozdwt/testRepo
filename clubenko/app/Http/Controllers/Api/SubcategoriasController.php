<?php

namespace App\Http\Controllers\Api;

use App\Repositories\SubcategoriaRepo;
use App\Repositories\CuponRepo;
use App\Repositories\PromocionRepo;
use App\Transformers\SubCategoriasTransformer;
use App\Transformers\CuponesTransformer;
use App\Transformers\PromocionesTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SubcategoriasController extends BaseController
{

    public function __construct(SubcategoriaRepo $subcategoriaRepo, CuponRepo $cuponRepo, PromocionRepo $promocionRepo)
    {
        parent::__construct();
        $this->cuponRepo = $cuponRepo;
        $this->promocionRepo = $promocionRepo;
        $this->subcategoriaRepo = $subcategoriaRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = $this->subcategoriaRepo->get_subcategorias();
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->collection($data, new SubCategoriasTransformer);
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
            $data = $this->subcategoriaRepo->get_subcategoria_id($id);
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
        return $this->response->item($data, new SubCategoriasTransformer());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cupones($id_subcategoria)
    {
        if (!is_numeric($id_subcategoria)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $data = $this->cuponRepo->cupones_por_subcategoria($id_subcategoria);
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
    public function promociones($id_subcategoria)
    {
        if (!is_numeric($id_subcategoria)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $data = $this->promocionRepo->promociones_por_subcategoria($id_subcategoria);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->paginator($data, new PromocionesTransformer);
    }

}
