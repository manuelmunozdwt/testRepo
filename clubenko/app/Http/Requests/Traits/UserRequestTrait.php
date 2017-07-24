<?php

namespace App\Http\Requests\Traits;

trait UserRequestTrait
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required',
            'password' => 'required|confirmed|min:6',
            'email' => 'required|email',
        ];
    }

    public function messages(){
        return [
            'nombre.required' => 'Por favor, introduzca su nombre.',
            'email.required' => 'Por favor, introduzca su email.',
            'email.email' => 'Por favor, introduzca un email válido.',
            'password.required' => 'Por favor introduzca una contraseña',
            'password.confirmed' => 'La contraseña no coincide.',
            'password.min' => 'La contraseña debe contener al menos 6 caracteres.'
        ];
    }
}