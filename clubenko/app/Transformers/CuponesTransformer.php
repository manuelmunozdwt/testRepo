<?php

namespace App\Transformers;

use App\Models\Cupon;
use League\Fractal\TransformerAbstract;

class CuponesTransformer extends TransformerAbstract
{
    public function __construct()
    {
        $this->categoriasTransformer = new CategoriasTransformer();
        $this->subCategoriasTransformer = new SubCategoriasTransformer();
        $this->filtrosTransformer = new FiltrosTransformer();
    }
    
    public function transform($entity) {
        if($entity instanceof Cupon) {
            return [
                'id' => $entity->id,
                'titulo' => $entity->titulo,
                'descripcion' => $entity->descripcion,
                'descripcion_corta' => $entity->descripcion_corta,
                'condiciones' => $entity->condiciones,
                'imagen' => $entity->imagen,
                'logo' => $entity->logo,
                'codigo' => $entity->codigo,
                'fecha_inicio' => $entity->fecha_inicio,
                'fecha_fin' => $entity->fecha_fin,
                'confirmado' => (bool)$entity->confirmado,
                'descargas' => $entity->descargas,
                'categoria' => $this->categoriasTransformer->transform($entity['categoria']),
                'subcategoria' => $this->subCategoriasTransformer->transform($entity['subcategoria']),
                'filtro' => $this->filtrosTransformer->transform($entity['filtro']),
                'visitas' => $entity->visitas,
                'valoracion' => $entity->valoracion,
            ];
        }else{
            return null;
        }
    }
}