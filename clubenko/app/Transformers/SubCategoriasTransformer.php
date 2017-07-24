<?php

namespace App\Transformers;

use App\Models\Subcategoria;
use League\Fractal\TransformerAbstract;

class SubCategoriasTransformer extends TransformerAbstract
{
    public function transform($entity) {
        if($entity instanceof Subcategoria){
            return [
                'id' => $entity->id,
                'nombre' => $entity->nombre,
                'imagen' => $entity->imagen,
                'estandar' => $entity->estandar,
            ];
        }else{
            return null;
        }
    }
}