<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Input;
class SubcategoriaRequest extends Request
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
            'nombre' => 'required|max:100|unique:subcategorias,nombre,NULL,id,categoria_id,'.Input::get('categoria_id'),
        ];
    }

    public function messages(){
        return [
            'nombre.required' => 'Por favor, introduzca un nombre válido.',
            'nombre.max' => 'El nombre de la subcategoría no debe tener más de 100 caracteres.',
            'nombre.unique' => 'Esa subcategoría ya existe.'
        ];
    }
}
