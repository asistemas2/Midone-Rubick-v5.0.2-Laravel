<?php

namespace App\Http\Requests\Gestion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMantenimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => ['required', 'string', 'max:30', Rule::unique('mantenimientos')->ignore($this->route('mantenimiento'))],
            'tipo_activo' => 'required|in:inmueble,equipo',
            'activo_id' => 'required|integer|min:1',
            'tipo_mantenimiento' => 'required|in:preventivo,correctivo,predictivo',
            'descripcion' => 'nullable|string',
            'fecha_programada' => 'nullable|date',
            'fecha_realizada' => 'nullable|date',
            'responsable' => 'nullable|string|max:200',
            'tipo_responsable' => 'nullable|in:Mincit,Operador ZFP,Usuario-calificado',
            'empresa_contratista' => 'nullable|string|max:200',
            'estado' => 'required|in:programado,en_proceso,completado,cancelado',
            'observaciones' => 'nullable|string',
            'activo' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.unique' => 'Este código ya existe.',
            'tipo_activo.required' => 'El tipo de activo es obligatorio.',
            'activo_id.required' => 'Debe seleccionar un activo.',
            'tipo_mantenimiento.required' => 'El tipo de mantenimiento es obligatorio.',
            'estado.required' => 'El estado es obligatorio.',
        ];
    }
}
