<?php

namespace App\Http\Requests\Parametrizacion;

use Illuminate\Foundation\Http\FormRequest;

class StoreCriticidadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'    => ['required', 'string', 'max:50', 'unique:criticidades,nombre'],
            'nivel'     => ['required', 'integer', 'min:0', 'max:255'],
            'color_hex' => ['sometimes', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'orden'     => ['sometimes', 'integer', 'min:0', 'max:255'],
            'activo'    => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la criticidad es obligatorio.',
            'nombre.unique'   => 'Esta criticidad ya está registrada.',
            'nivel.required'  => 'El nivel es obligatorio.',
            'nivel.integer'   => 'El nivel debe ser un número entero.',
            'color_hex.regex' => 'El color debe tener formato hexadecimal (#RRGGBB).',
        ];
    }
}
