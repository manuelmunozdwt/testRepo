<?php

namespace App\Transformers;

use App\Models\Filtro;
use League\Fractal\TransformerAbstract;

class FiltrosTransformer extends TransformerAbstract
{
    public function transform($entity) {
        if($entity instanceof Filtro){
            return [
                'id' => $entity->id,
                'nombre' => $entity->nombre,
                'imagen' => $entity->imagen,
            ];
        }else{
            return null;
        }
    }
}