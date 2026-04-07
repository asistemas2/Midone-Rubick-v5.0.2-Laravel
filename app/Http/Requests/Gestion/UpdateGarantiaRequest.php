<?php

namespace App\Http\Requests\Gestion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGarantiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => ['required', 'string', 'max:30', Rule::unique('garantias')->ignore($this->route('garantia'))],
            'mantenimiento_id' => 'nullable|integer|exists:mantenimientos,id',
            'tipo_activo' => 'required|in:inmueble,equipo',
            'activo_id' => 'nullable|integer|min:1',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'proveedor' => 'nullable|string|max:200',
            'terminos' => 'nullable|string',
            'monto' => 'nullable|numeric|min:0',
            'estado' => 'required|in:activa,vencida,en_tramite',
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
            'estado.required' => 'El estado es obligatorio.',
            'fecha_fin.after_or_equal' => 'La fecha fin debe ser posterior a la fecha de inicio.',
        ];
    }
}
