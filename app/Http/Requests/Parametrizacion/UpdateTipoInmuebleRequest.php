<?php

namespace App\Http\Requests\Parametrizacion;

use App\Http\Requests\Concerns\NormalizaActivo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTipoInmuebleRequest extends FormRequest
{
    use NormalizaActivo;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'      => ['required', 'string', 'max:100', Rule::unique('tipos_inmueble', 'nombre')->ignore($this->route('tipos_inmueble'))],
            'descripcion' => ['nullable', 'string'],
            'activo'      => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del tipo de inmueble es obligatorio.',
            'nombre.unique'   => 'Este tipo de inmueble ya está registrado.',
        ];
    }
}
