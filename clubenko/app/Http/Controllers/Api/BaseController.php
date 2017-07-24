<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ImagenRequest;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Repositories\FiltroRepo;
use App\Repositories\UserRepo;

class BaseController extends Controller
{
    use Helpers;

    public function __construct()
    {
        $this->filtroRepo = new FiltroRepo();
        $this->userRepo = new UserRepo();
    }


    /**
     * Request util para todos los controladores.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function subirImagen(ImagenRequest $request, $id, $data)
    {

        if($data instanceof \App\Models\User){
            $entityName = 'usuarios';
        }else if($data instanceof \App\Models\Tienda){
            $entityName = 'tiendas';
        }

        try{
            $requestData = $request->intersect('');

            $imagenPath = subir_imagen('logo',$requestData['logo'], $data->id, $entityName);

            if($entityName == 'usuarios'){
                $data->imagen = $imagenPath;
            }else{
                $data->logo = $imagenPath;
            }

            $data->save();
        }catch(\Exception $exception){
            return $this->response->error('Ha ocurrido un error.', 404);
        }

        return $this->response->created()->withHeader('Content-Type', 'application/json');
    }

    public function getPrecioConDescuento($precio, $filtro_id){

        $porcentaje = $this->getPorcentaje($filtro_id);

        $precio = str_replace(",", ".", $precio);

        $precio_calculado = $precio - ((($porcentaje/100) * $precio) );

        //el valor minimo de un precio con descuento el de 50 centimos
        if($precio_calculado < '0.50'){
            throw new StoreResourceFailedException('No se pudo crear la promoción', ["fecha_fin" => 'El precio con el descuento no puede ser menor de 0.50€']);
        }else{
            return $precio_calculado;
        }
    }

    private function getPorcentaje($filtro_id)
    {

        $nombreFiltro = $this->filtroRepo->nombre_filtro($filtro_id)->first()['nombre'];

        if(strpos( $nombreFiltro, "%" ) !== false){
            $porcentaje = (int) str_replace("%","",$nombreFiltro);
        }else{
            //@todo hay que ver que valor se debe devolver cuando es un 2x1
            $porcentaje = 0;
        }
        return $porcentaje;

    }

    /**
     * Construye el slug del cupón
     * @param  [string] [datos para construir el slug]
     * @return string [slug construido]
     */
    public function construir_slug($string, $model)
    {
        //tomamos el nombre y apellidos insertados para construir el slug base
        $baseslug = normalizar_string($string);

        //Miramos si ese slug ya existe
        $existe = $model->where('slug', $baseslug)->count();

        //Si no existe, lo guardamos
        if($existe == 0){
            $string = $baseslug;
            //si existe, añadimos un contador al final (2, porque sería el segundo usuario con ese nombre y apellido)
        }else{
            $i = 2;
            $slug=$baseslug.'-'.$i;
            $existe = $model->where('slug', $slug)->count();
            //volvemos a checkear si existe. Mientras exista el slug ($existe sea = 1)
            while ($existe > 0){
                // añadimos uno al contador
                $i = $i+1;
                $slug = $baseslug.'-'.$i;
                //y volvemos a checkear
                $existe = $model->where('slug', $slug)->count();
            }
            //cuando no encontremos el slug en la bbdd ($existe = 0), guardamos el slug
            $string = $slug;
        }
        return $string;
    }

}