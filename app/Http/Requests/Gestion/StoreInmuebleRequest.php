<?php

namespace App\Http\Requests\Gestion;

use Illuminate\Foundation\Http\FormRequest;

class StoreInmuebleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => 'required|string|max:30|unique:inmuebles,codigo',
            'nombre' => 'required|string|max:200',
            'bloque_id' => 'nullable|integer|exists:bloques,id',
            'tipo_inmueble_id' => 'nullable|integer|exists:tipos_inmueble,id',
            'direccion' => 'nullable|string|max:300',
            'area_m2' => 'nullable|numeric|min:0|max:9999999999.99',
            'area_construida_m2' => 'nullable|numeric|min:0|max:9999999999.99',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'estado' => 'required|in:operativo,mantenimiento,fuera_servicio',
            'nivel_deterioro_id' => 'nullable|integer|exists:niveles_deterioro,id',
            'fecha_construccion' => 'nullable|date',
            'valor_catastral' => 'nullable|numeric|min:0',
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
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
            'latitud.between' => 'La latitud debe estar entre -90 y 90.',
            'longitud.between' => 'La longitud debe estar entre -180 y 180.',
        ];
    }
}
