<?php
// app/Http/Requests/Gestion/UpdateMantenimientoRequest.php

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
            // ── Identificación ────────────────────────────────
            'codigo'                 => [
                'required', 'string', 'max:30',
                Rule::unique('mantenimientos', 'codigo')->ignore($this->route('mantenimiento')),
            ],

            // ── Activo relacionado ────────────────────────────
            'tipo_activo'            => 'required|in:inmueble,equipo',
            'activo_id'              => 'required|integer|min:1',

            // ── Clasificación ─────────────────────────────────
            'tipo_mantenimiento'     => 'required|in:preventivo,correctivo,predictivo',
            'criterio_mantenimiento' => 'nullable|in:riesgo_vida,riesgo_operacional,riesgo_sancionatorio,riesgo_activo',
            'criticidad_mantenimiento_id' => 'nullable|integer|exists:criticidades_mantenimiento,id|required_with:criterio_mantenimiento',

            // ── Detalles ──────────────────────────────────────
            'descripcion'            => 'nullable|string',
            'fecha_programada'       => 'nullable|date',
            'fecha_realizada'        => 'nullable|date',

            // ── Responsable ───────────────────────────────────
            'responsable'            => 'nullable|string|max:200',
            'tipo_responsable'       => 'nullable|in:Mincit,Operador ZFP,Usuario-calificado',
            'empresa_contratista'    => 'nullable|string|max:200',

            // ── Costos ────────────────────────────────────────
            'presupuesto_aprobado'       => 'nullable|numeric|min:0|max:9999999999999.99',

            // ── Estado ────────────────────────────────────────
            'estado'                 => 'required|in:programado,en_proceso,completado,cancelado',
            'observaciones'          => 'nullable|string',
            'activo'                 => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required'                        => 'El código es obligatorio.',
            'codigo.unique'                          => 'Este código ya existe.',
            'tipo_activo.required'                   => 'El tipo de activo es obligatorio.',
            'activo_id.required'                     => 'Debe seleccionar un activo.',
            'tipo_mantenimiento.required'            => 'El tipo de mantenimiento es obligatorio.',
            'criterio_mantenimiento.in'              => 'El criterio seleccionado no es válido.',
            'criticidad_mantenimiento_id.required_with' => 'Debe seleccionar una criticidad cuando elige un criterio.',
            'criticidad_mantenimiento_id.exists'     => 'La criticidad seleccionada no existe.',
            'presupuesto_aprobado.numeric'               => 'El presupuesto aprobado debe ser un valor numérico.',
            'presupuesto_aprobado.min'                   => 'El presupuesto aprobado no puede ser negativo.',
            'estado.required'                        => 'El estado es obligatorio.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'activo' => $this->boolean('activo', true),
        ]);
    }
}