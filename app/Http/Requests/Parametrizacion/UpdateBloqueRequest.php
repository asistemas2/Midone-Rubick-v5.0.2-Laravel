<?php

namespace App\Http\Requests\Parametrizacion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBloqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'      => ['required', 'string', 'max:100'],
            'codigo'      => ['required', 'string', 'max:20', Rule::unique('bloques', 'codigo')->ignore($this->route('bloque'))],
            'descripcion' => ['nullable', 'string'],
            'area_m2'     => ['nullable', 'numeric', 'min:0', 'max:9999999999.99'],
            'activo'      => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del bloque es obligatorio.',
            'codigo.required' => 'El código del bloque es obligatorio.',
            'codigo.unique'   => 'Este código ya está registrado.',
            'area_m2.numeric' => 'El área debe ser un valor numérico.',
        ];
    }
}
