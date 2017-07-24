<?php

namespace App\Transformers;

use App\Models\Provincias;
use League\Fractal\TransformerAbstract;

class ProvinciasTransformer extends TransformerAbstract
{
    public function transform($entity) {
        if($entity instanceof Provincias){
            return [
                'id' => $entity->id,
                'nombre' => $entity->nombre,
                'slug' => $entity->slug,
            ];
        }else{
            return null;
        }
    }
}