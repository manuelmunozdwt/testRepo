<?php

namespace App\Http\Requests\Traits;

trait PromocionRequestTrait
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
        return  [
            'titulo' => 'required',
            'descripcion' => 'required',
            'descripcion_corta' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'after:fecha_inicio',
            'categoria_id' => 'required',
            'filtro_id' => 'required',
            'tienda' => 'required',
            'imagen' => 'string|min:5|max:255',
            'logo' => 'required|in:blanco,negro,logo',
            'condiciones' => 'required',
            'tipo_promocion' => 'required'
        ];
    }

    public function messages(){
        return [
            'titulo.required' => 'Por favor, introduzca un título.',
            'descripcion.required' => 'Por favor, introduzca una descripción.',
            'descripcion_corta.required' => 'Por favor, introduzca una descripción breve.',
            'fecha_inicio.required' => 'Por favor, introduzca la fecha de inicio.',
            'fecha_inicio.date' => 'La fecha de inicio tiene que tener formato fecha.',
            'fecha_fin.after' => 'La fecha de fin debe ser superior a la fecha de inicio.',
            'fecha_fin.date' => 'La fecha de fin tiene que tener formato fecha.',
            'categoria.required' => 'Por favor, seleccione una categoría.',
            'filtro_id.required' => 'Por favor, defina un descuento.',
            'tienda.required' => 'Por favor, seleccione al menos una tienda.',
            'imagen.string' => 'El nombre de la imágen debe ser alfanumérico.',
            'imagen.min' => 'El nombre de la imágen debe superar los 5 caracteres.',
            'imagen.max' => 'El nombre de la imágen no debe superar los 255 caracteres.',
            'logo.required' => 'Por favor, seleccione una imagen.',
            'logo.in' => "Por favor, seleccione entre las opciones 'blanco', 'negro' ó 'logo'.",
            'condiciones.required' => 'Por favor, indroduzca las condiciones de la promoción.',
            'precio_descuento.required' => 'Por favor, defina el precio con descuento',
            'tipo_promocion.required' => 'Por favor, idica el tipo de promocion'
        ];
    }
}