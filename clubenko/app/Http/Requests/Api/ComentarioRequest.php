<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;
use App\Http\Requests\Traits\ComentarioRequestTrait;

class ComentarioRequest extends FormRequest
{
    use  ComentarioRequestTrait {
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
            'comentario',
            'cupon_id'
        ];
        if($this->method() == 'POST') {
            $fields[] = 'user_id';
        }

        return parent::intersect($fields);
    }
}