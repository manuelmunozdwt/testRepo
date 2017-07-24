<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;
use App\Http\Requests\Traits\TiendaRequestTrait;

class TiendaRequest extends FormRequest
{
    use  TiendaRequestTrait {
        rules as public traitrules;
        messages as public traitmessages;
    }

    public function rules(){
        $rules = $this->traitrules();
        if($this->method() == 'POST'){
            $rules['user_id'] = 'required|numeric';
        }
        return $rules;
    }

    public function messages(){
        $messages = $this->traitmessages();
        if($this->method() == 'POST') {
            $messages['user_id.required'] = 'Por favor introduzca un id de usuario comercio.';
            $messages['user_id.numeric'] = 'El id de usuario debe ser un número.';
        }
        return $messages;
    }

    public function intersect($keys){
        $fields = [
            'nombre',
            'logo',
            'direccion',
            'telefono',
            'web',
            'latitud',
            'longitud',
            'provincia_id'
        ];
        if($this->method() == 'POST') {
            $fields[] = 'user_id';
        }

        return parent::intersect($fields);
    }
}