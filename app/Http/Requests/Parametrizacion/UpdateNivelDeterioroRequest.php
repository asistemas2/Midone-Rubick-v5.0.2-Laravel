<?php

namespace App\Http\Requests\Parametrizacion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNivelDeterioroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('niveles_deterioro');

        return [
            'nombre'    => ['required', 'string', 'max:50', Rule::unique('niveles_deterioro', 'nombre')->ignore($id)],
            'codigo'    => ['required', 'string', 'max:20', Rule::unique('niveles_deterioro', 'codigo')->ignore($id)],
            'color_hex' => ['sometimes', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'orden'     => ['sometimes', 'integer', 'min:0', 'max:255'],
            'activo'    => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'  => 'El nombre del nivel de deterioro es obligatorio.',
            'nombre.unique'    => 'Este nivel de deterioro ya está registrado.',
            'codigo.required'  => 'El código es obligatorio.',
            'codigo.unique'    => 'Este código ya está registrado.',
            'color_hex.regex'  => 'El color debe tener formato hexadecimal (#RRGGBB).',
        ];
    }
}
