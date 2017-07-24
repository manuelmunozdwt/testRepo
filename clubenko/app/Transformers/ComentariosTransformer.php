<?php

namespace App\Transformers;

use App\Models\Comentario;
use League\Fractal\TransformerAbstract;

class ComentariosTransformer extends TransformerAbstract
{
    public function __construct()
    {
        $this->usersTransformer = new UsersTransformer();
        $this->cuponesTransformer = new CuponesTransformer();
    }

    public function transform($entity) {
        if($entity instanceof Comentario){
            return [
                'id' => $entity->id,
                'comentario' => $entity->comentario,
                'usuario' => $this->usersTransformer->transform($entity['usuario']),
                'cupon' => $this->cuponesTransformer->transform($entity['cupon']),
            ];
        }else{
            return null;
        }
    }
}