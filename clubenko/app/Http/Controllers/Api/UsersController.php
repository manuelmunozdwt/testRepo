<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Requests\Api\ImagenRequest;
use App\Repositories\ComentarioRepo;
use App\Transformers\UsersTransformer;
use App\Repositories\TiendaRepo;
use App\Transformers\TiendasTransformer;
use App\Transformers\ComentariosTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UsersController extends BaseController
{
    public function __construct(TiendaRepo $tiendaRepo, ComentarioRepo $comentarioRepo)
    {
        parent::__construct();
        $this->tiendaRepo = $tiendaRepo;
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
            $data = $this->userRepo->get_todos();
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->paginator($data, new UsersTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try{
            $requestData = $this->modifyRequestData($request);
            $data = $this->userRepo->crear_usuario($requestData);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->item($data, new UsersTransformer)->statusCode('201');
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
            $data = $this->userRepo->usuario($id);
            
            
        }catch(\Exception $exception){
            throw new BadRequestHttpException('Error en la petición.');
        }finally{
            if(!is_numeric($id)) {
                throw new BadRequestHttpException('El parámetro debe ser numérico.');
            }
            if(!$data){
                throw new NotFoundHttpException('Recurso no existente.');
            }
        }

        return $this->response->item($data, new UsersTransformer);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        if (!is_numeric($id)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $requestData = $this->modifyRequestData($request);

            $data = $this->userRepo->usuario($id);
            
            if (!$data) {
                throw new NotFoundHttpException();
            }
            $data->name = $requestData['name'];
            $data->apellidos = $requestData['apellidos'];
            $data->dni = $requestData['dni'];
            $data->email = $requestData['email'];
            $data->password = $requestData['password'];
            $data->rol = $requestData['rol'];
            $data->slug = $requestData['slug'];
            $data->confirmado = $requestData['confirmado'];
            if (isset($requestData['nombre_comercio'])) {
                $data->nombre_comercio =  $requestData['nombre_comercio'];
            }
            if (isset($requestData['web_comercio'])) {
                $data->web_comercio =  $requestData['web_comercio'];
            }
            if (isset($requestData['sobre_comercio'])) {
                $data->sobre_comercio =  $requestData['sobre_comercio'];
            }
            $data->save();

        }catch (NotFoundHttpException $exception) {
            
            return $this->response->error('Recurso no existente', 404);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->item($data, new UsersTransformer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $data = $this->userRepo->usuario($id);
            
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
            $data = $this->userRepo->usuario($id);
            $response = $this->subirImagen($request, $id, $data);
        }catch(\Exception $exception){
            throw new BadRequestHttpException('Error en la petición.');
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
        if (!is_numeric($id)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $data = $this->userRepo->get_user_deleted($id);
            
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
    
     /* Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tiendas($id_comercio)
    {
        if (!is_numeric($id_comercio)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $data = $this->tiendaRepo->tiendas_por_comercio($id_comercio);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->paginator($data, new TiendasTransformer);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comentarios($id_usuario)
    {
        if (!is_numeric($id_usuario)) {
            throw new BadRequestHttpException('El parámetro debe ser numérico.');
        }
        try{
            $data = $this->comentarioRepo->comentarios_por_usuario($id_usuario);
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->paginator($data, new ComentariosTransformer);
    }

    public function modifyRequestData($request)
    {

        $requestData = $request->intersect('');

        $requestData['name'] = $requestData['nombre'];
        unset($requestData['nombre']);
        $requestData['password'] = bcrypt($requestData['password']);
        $requestData['slug'] = $this->construir_slug($requestData['name'], new \App\Models\User);
        //se lo confirma por defecto
        $requestData['confirmado'] = true;

        return $requestData;
    }
}
