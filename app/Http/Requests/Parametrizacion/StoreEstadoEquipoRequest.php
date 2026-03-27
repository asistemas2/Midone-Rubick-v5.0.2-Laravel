<?php

namespace App\Http\Requests\Parametrizacion;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstadoEquipoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'    => ['required', 'string', 'max:100', 'unique:estados_equipo,nombre'],
            'codigo'    => ['required', 'string', 'max:20', 'unique:estados_equipo,codigo'],
            'color_hex' => ['sometimes', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'activo'    => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del estado de equipo es obligatorio.',
            'nombre.unique'   => 'Este estado de equipo ya está registrado.',
            'codigo.required' => 'El código es obligatorio.',
            'codigo.unique'   => 'Este código ya está registrado.',
            'color_hex.regex' => 'El color debe tener formato hexadecimal (#RRGGBB).',
        ];
    }
}
