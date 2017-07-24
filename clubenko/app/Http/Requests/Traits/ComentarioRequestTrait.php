<?php

namespace App\Http\Requests\Traits;

trait ComentarioRequestTrait
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
            'comentario' => 'required',
            'cupon_id' => 'required|numeric'
        ];
    }

    public function messages(){
        return [
            'comentario.required' => 'Por favor, introduzca el comentario.',
            'cupon_id.required' => 'No se encontró el id del cupon.',
            'cupon_id.numeric' => 'El id de cupón debe ser un número.',
        ];
    }
}