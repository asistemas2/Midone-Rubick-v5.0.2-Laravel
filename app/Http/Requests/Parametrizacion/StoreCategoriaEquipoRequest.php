<?php

namespace App\Http\Requests\Parametrizacion;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaEquipoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'         => ['required', 'string', 'max:150', 'unique:categorias_equipo,nombre'],
            'tipo_equipo_id' => ['nullable', 'integer', 'exists:tipos_equipo,id'],
            'descripcion'    => ['nullable', 'string'],
            'activo'         => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'        => 'El nombre de la categoría es obligatorio.',
            'nombre.unique'          => 'Esta categoría ya está registrada.',
            'tipo_equipo_id.exists'  => 'El tipo de equipo seleccionado no existe.',
        ];
    }
}
