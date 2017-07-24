<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;
use App\Http\Requests\Traits\UserRequestTrait;
use App\Http\Requests\Traits\CommonRequestTrait;

class UserRequest extends FormRequest
{
    use CommonRequestTrait, UserRequestTrait {
        rules as public traitrules;
        messages as public traitmessages;
    }

    public function rules(){

        //Para que excluya el row al update en los unique
        $id = $this->getSegmentFromEnd();

        $rules = $this->traitrules();
        $rules['nombre'] = 'required|max:255';
        $rules['apellidos'] = 'required|max:255';
        $rules['nombre_comercio'] = 'required|max:255';
        $rules['dni'] = 'required|max:255|unique:users,dni,'.$id;
        $rules['email'] = 'required|email|unique:users,email,'.$id;
        $rules['rol'] = 'required|in:1,2';
        $rules['imagen'] = 'string|max:255|min:5';
        return $rules;
    }

    public function messages(){
        $messages = $this->traitmessages();
        $messages['nombre.max'] = 'El nombre no debe superar los 255 caracteres.';
        $messages['apellidos.required'] = 'Por favor introduzca un apellido.';
        $messages['apellidos.max'] = 'El campo apellidos no debe superar los 255 caracteres.';
        $messages['nombre_comercio.required'] = 'Por favor, introduzca el nombre del comercio.';
        $messages['nombre_comercio.max'] = 'El nombre del comercio no debe superar los 255 caracteres.';
        $messages['dni.required'] = 'Por favor, introduzca un dni.';
        $messages['dni.dni'] = 'El formato de dni no es válido.';
        $messages['dni.max'] = 'El dni no debe superar los 255 caracteres.';
        $messages['dni.unique'] = 'El dni introducido ya existe, por favor, introduzca otro dni.';
        $messages['email.unique'] = 'El email introducido ya existe, por favor, introduzca otro.';
        $messages['rol.required'] = 'Por favor, introduzca un rol.';
        $messages['rol.in'] = 'El valor de rol no es válido.';
        $messages['imagen.string'] = 'El nombre de la imágen debe ser alfanumérico.';
        $messages['imagen.min'] = 'El nombre de la imágen debe superar los 5 caracteres.';
        $messages['imagen.max'] = 'El nombre de la imágen no debe superar los 255 caracteres.';
        return $messages;
    }

    public function intersect($keys){
        return parent::intersect([
            'nombre',
            'dni',
            'apellidos',
            'email',
            'password',
            'password_confirmation',
            'imagen',
            'confirmado',
            'sobre_comercio',
            'web_comercio',
            'rol',
            'nombre_comercio'
        ]);
    }
}