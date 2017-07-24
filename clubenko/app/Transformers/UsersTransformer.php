<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UsersTransformer extends TransformerAbstract
{
    public function transform($entity) {
        if($entity instanceof User){
            return [
                'id' => $entity->id,
                'dni' => $entity->dni,
                'nombre' => $entity->name,
                'apellidos' => $entity->apellidos,
                'email' => $entity->email,
                'imagen' => $entity->imagenAbsoluto,
            ];
        }else{
            return null;
        }
    }
}