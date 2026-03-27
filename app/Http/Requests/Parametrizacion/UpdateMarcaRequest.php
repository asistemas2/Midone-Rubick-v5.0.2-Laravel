<?php

namespace App\Http\Requests\Parametrizacion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMarcaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'      => ['required', 'string', 'max:200', Rule::unique('marcas', 'nombre')->ignore($this->route('marca'))],
            'pais_origen' => ['nullable', 'string', 'max:100'],
            'activo'      => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la marca es obligatorio.',
            'nombre.unique'   => 'Esta marca ya está registrada.',
        ];
    }
}
