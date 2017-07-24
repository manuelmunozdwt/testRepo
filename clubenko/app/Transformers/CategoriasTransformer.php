<?php

namespace App\Transformers;

use App\Models\Categoria;
use League\Fractal\TransformerAbstract;

class CategoriasTransformer extends TransformerAbstract
{
    public function transform($entity) {
        if($entity instanceof Categoria){
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