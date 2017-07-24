<?php

namespace App\Http\Requests\Traits;

trait TiendaRequestTrait
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
            'direccion' => 'required',
            'telefono' => 'required|numeric|min:8',
            'provincia_id' => 'required'
        ];
    }

    public function messages(){
        return [
            'nombre.required' => 'Por favor, introduzca el nombre de la nueva tienda.',
            'direccion.required' => 'Por favor, introduzca una dirección.',
            'telefono.required' => 'Por favor, introduzca un número de teléfono.',
            'telefono.numeric' => 'El número de teléfono es incorrecto. Por favor, introduzca un número de 8 dígitos, sin espacios ni guiones.',
            'telefono.min' => 'El número de teléfono es incorrecto. Por favor, introduzca un número de 8 dígitos, sin espacios ni guiones.',
        ];
    }
}