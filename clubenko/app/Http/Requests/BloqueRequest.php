<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BloqueRequest extends Request
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
            'cat_bloque' => 'required_if:subcat_bloque,',
            'primer_cupon' => 'required',
            'segundo_cupon' => 'required'
        ];
    }

    public function messages(){
        return [
            'cat_bloque.required_if' => 'Por favor, selecciona una categoría o subcategoría para la portada.',
            'primer_cupon.required' => 'Por favor, selecciona una oferta para el primer cupón.',
            'segundo_cupon.required' => 'Por favor, selecciona una oferta para el segundo cupón.'
        ];
    }
}
