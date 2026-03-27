<?php

namespace App\Http\Requests\Parametrizacion;

use Illuminate\Foundation\Http\FormRequest;

class StorePeriodicidadMantenimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'           => ['required', 'string', 'max:100', 'unique:periodicidades_mantenimiento,nombre'],
            'dias_frecuencia'  => ['required', 'integer', 'min:1', 'max:3650'],
            'descripcion'      => ['nullable', 'string'],
            'activo'           => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'          => 'El nombre de la periodicidad es obligatorio.',
            'nombre.unique'            => 'Esta periodicidad ya está registrada.',
            'dias_frecuencia.required' => 'Los días de frecuencia son obligatorios.',
            'dias_frecuencia.integer'  => 'Los días de frecuencia deben ser un número entero.',
            'dias_frecuencia.min'      => 'Los días de frecuencia deben ser al menos 1.',
        ];
    }
}
