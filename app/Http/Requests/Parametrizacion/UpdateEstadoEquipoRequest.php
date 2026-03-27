<?php

namespace App\Http\Requests\Parametrizacion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEstadoEquipoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('estados_equipo');

        return [
            'nombre'    => ['required', 'string', 'max:100', Rule::unique('estados_equipo', 'nombre')->ignore($id)],
            'codigo'    => ['required', 'string', 'max:20', Rule::unique('estados_equipo', 'codigo')->ignore($id)],
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
