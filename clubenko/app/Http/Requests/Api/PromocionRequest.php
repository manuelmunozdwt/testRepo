<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;
use App\Http\Requests\Traits\PromocionRequestTrait;

class PromocionRequest extends FormRequest
{
    use  PromocionRequestTrait {
        rules as public traitrules;
        messages as public traitmessages;
    }

    public function rules(){
        $rules = $this->traitrules();
        $rules['fecha_fin'] = 'after:fecha_inicio|date|required';
        return $rules;
    }

    public function messages(){
        $messages = $this->traitmessages();
        $messages['fecha_fin.required'] = 'Por favor introduzca una fecha fin.';
        return $messages;
    }

    public function intersect($keys){
        return parent::intersect([
            'titulo',
            'descripcion',
            'descripcion_corta',
            'condiciones',
            'imagen',
            'logo',
            'fecha_inicio',
            'fecha_fin',
            'confirmado',
            'categoria_id',
            'subcategoria_id',
            'filtro_id',
            'precio',
            'reserva',
            'tipo_promocion',
            'user_id',
            'tienda'
        ]);
    }
}