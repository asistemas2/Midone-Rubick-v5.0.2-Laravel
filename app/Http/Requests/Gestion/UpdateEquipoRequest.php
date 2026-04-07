<?php

namespace App\Http\Requests\Gestion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => ['required', 'string', 'max:30', Rule::unique('equipos')->ignore($this->route('equipo'))],
            'nombre' => 'required|string|max:300',
            'tipo_equipo_id' => 'nullable|integer|exists:tipos_equipo,id',
            'categoria_equipo_id' => 'nullable|integer|exists:categorias_equipo,id',
            'marca_id' => 'nullable|integer|exists:marcas,id',
            'modelo' => 'nullable|string|max:150',
            'no_serie' => 'nullable|string|max:100',
            'inmueble_id' => 'nullable|integer|exists:inmuebles,id',
            'ubicacion_especifica' => 'nullable|string|max:300',
            'capacidad' => 'nullable|string|max:100',
            'voltaje' => 'nullable|string|max:100',
            'potencia' => 'nullable|string|max:100',
            'frecuencia' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'fecha_adquisicion' => 'nullable|date',
            'fecha_instalacion' => 'nullable|date',
            'vida_util_anios' => 'nullable|integer|min:0|max:200',
            'proveedor' => 'nullable|string|max:200',
            'garantia_meses' => 'nullable|integer|min:0|max:600',
            'estado_equipo_id' => 'nullable|integer|exists:estados_equipo,id',
            'criticidad_id' => 'nullable|integer|exists:criticidades,id',
            'periodicidad_mantenimiento_id' => 'nullable|integer|exists:periodicidades_mantenimiento,id',
            'ultimo_mantenimiento' => 'nullable|date',
            'proximo_mantenimiento' => 'nullable|date',
            'responsable' => 'nullable|string|max:200',
            'observaciones' => 'nullable|string',
            'activo' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.unique' => 'Este código ya existe.',
            'nombre.required' => 'El nombre es obligatorio.',
        ];
    }
}
