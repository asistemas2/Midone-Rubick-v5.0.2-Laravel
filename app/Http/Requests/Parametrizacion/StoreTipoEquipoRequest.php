<?php
namespace App\Http\Requests\Parametrizacion;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoEquipoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'              => ['required', 'string', 'max:100', 'unique:tipos_equipo,nombre'],
            'categoria_equipo_id' => ['nullable', 'integer', 'exists:categorias_equipo,id'],
            'descripcion'         => ['nullable', 'string'],
            'activo'              => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del tipo de equipo es obligatorio.',
            'nombre.unique'   => 'Este tipo de equipo ya está registrado.',
            'categoria_equipo_id.exists' => 'La categoría seleccionada no existe.',
        ];
    }
}