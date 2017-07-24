<?php

namespace App\Http\Controllers\Api;

use App\Repositories\CategoriaRepo;
use App\Repositories\CuponRepo;
use App\Repositories\PromocionRepo;
use App\Transformers\CategoriasTransformer;
use App\Transformers\CuponesTransformer;
use App\Transformers\PromocionesTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CategoriasController extends BaseController
{

    public function __construct(CategoriaRepo $categoriaRepo, CuponRepo $cuponRepo, PromocionRepo $promocionRepo)
    {
        parent::__construct();
        $this->cuponRepo = $cuponRepo;
        $this->promocionRepo = $promocionRepo;
        $this->categoriaRepo = $categoriaRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = $this->categoriaRepo->get_categorias();
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->collection($data, new CategoriasTransformer);
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
            $data = $this->categoriaRepo->get_categoria_id($id);
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
        return $this->response->item($data, new CategoriasTransformer());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cupones($id_categoria)
    {
        try{
            $data = $this->cuponRepo->cupones_por_categoria($id_categoria);
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
    public function promociones($id_categoria)
    {
        try{
            $data = $this->promocionRepo->promociones_por_categoria($id_categoria);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->paginator($data, new PromocionesTransformer);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imagenes($id_categoria)
    {
        $data = null;
        try{
            $data = $this->categoriaRepo->get_categoria_id($id_categoria);
            if (!$data) {
                throw new NotFoundHttpException();
            }
            $img_array = $this->imagenes_de_carpeta($data['slug'], null);
            
            $host = request()->server('REQUEST_SCHEME');
            $host .= '://'.request()->server('HTTP_HOST');
            $slug = $data['slug'].'/';
            
            $a = array();
            
            foreach ($img_array as $value) {
                $object = new \stdClass();
                $object->name = $value;
                $object->path = $host . '/img/cupones/'.$slug .$value;
                
                array_push($a, $object);
            }
            $array['data'] = $a;
        }catch (\Exception $exception){
            throw new BadRequestHttpException('Error en la petición.');
        }finally{
            if(!is_numeric($id_categoria)){
                throw new BadRequestHttpException('El parámetro debe ser numérico.');
            }
            if(!$data){
                throw new NotFoundHttpException('Recurso no existente.');
            }
        }
        return $this->response->array($array, new CategoriasTransformer());
    }
    
    public function imagenes_de_carpeta($categoria_slug = null,$ruta_carpeta_img = null)
    {   

        //Si no declaramos la ruta, por defecto sacamos del directorio blog
        if (is_null($ruta_carpeta_img)) {
            //Abrimos el directorio donde están las imágenes de los
            $ruta_carpeta_img = 'cupones';
        }

        if (is_null($categoria_slug)) {

            //Abrimos el directorio donde están las imágenes de los
            $directorio = opendir(carpeta_public() . '/img/' . $ruta_carpeta_img);

        }
        else{
//var_dump(carpeta_public() . '/img/' . $ruta_carpeta_img . '/' . $categoria_slug . '/');die;
          //Abrimos el directorio donde están las imágenes de los
          $directorio = opendir(carpeta_public() . '/img/' . $ruta_carpeta_img . '/' . $categoria_slug . '/');

        }


        //Declaramos el array que vamos a devolver con las imágenes
        $arr_imgagenes_cupones = array();

        //obtenemos un archivo y luego otro sucesivamente
        while ($archivo = readdir($directorio))
        {
            //verificamos si es o no un directorio
            if (!is_dir($archivo) && count(explode('.', $archivo)) > 1 && $archivo != '.DS_Store' && $archivo != 'thumbnail')
            {   
              $arr_imgagenes_cupones[] = $archivo;
            }
        }

        return $arr_imgagenes_cupones;
    }

}
