<?php

namespace App\Transformers;

use App\Models\Tienda;
use League\Fractal\TransformerAbstract;

class TiendasTransformer extends TransformerAbstract
{
    public function __construct()
    {
        $this->provinciasTransformer = new ProvinciasTransformer();
    }

    public function transform($entity) {
        if($entity instanceof Tienda){
            return [
                'id' => $entity->id,
                'nombre' => $entity->nombre,
                'direccion' => $entity->direccion,
                'telefono' => $entity->telefono,
                'slug' => $entity->slug,
                'web' => $entity->web,
                'latitud' => $entity->latitud,
                'longitud' => $entity->longitud,
                'logo' => $entity->imagenAbsoluto,
                'provincia' => $this->provinciasTransformer->transform($entity['provincia']),
            ];
        }else{
            return null;
        }
    }
}