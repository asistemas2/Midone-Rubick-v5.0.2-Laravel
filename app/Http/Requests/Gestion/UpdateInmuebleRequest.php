<?php

namespace App\Http\Requests\Gestion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInmuebleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => ['required', 'string', 'max:30', Rule::unique('inmuebles')->ignore($this->route('inmueble'))],
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
            // Ficha técnica
            'ficha_tecnica' => 'nullable|array',
            'ficha_tecnica.area_calificada' => 'nullable|numeric|min:0',
            'ficha_tecnica.area_util' => 'nullable|numeric|min:0',
            'ficha_tecnica.area_bruta' => 'nullable|numeric|min:0',
            'ficha_tecnica.capacidad_electrica' => 'nullable|string|max:50',
            'ficha_tecnica.agua_diametro' => 'nullable|string|max:20',
            'ficha_tecnica.tuberia_aguas_lluvias' => 'nullable|string',
            'ficha_tecnica.cajas_inspeccion_pluvial' => 'nullable|string|max:255',
            'ficha_tecnica.red_contra_incendios' => 'nullable|string',
            'ficha_tecnica.gabinetes_ci' => 'nullable|integer|min:0',
            'ficha_tecnica.cubierta' => 'nullable|string',
            'ficha_tecnica.muros' => 'nullable|string',
            'ficha_tecnica.acabados' => 'nullable|string',
            'ficha_tecnica.pisos' => 'nullable|string',
            'ficha_tecnica.blindaje_juntas' => 'nullable|string',
            'ficha_tecnica.estructura' => 'nullable|string',
            'ficha_tecnica.puertas_ventanas' => 'nullable|string',
            'ficha_tecnica.muelle' => 'nullable|boolean',
            'ficha_tecnica.mezzanine' => 'nullable|boolean',
            'ficha_tecnica.bloques_banos' => 'nullable|integer|min:0',
            'ficha_tecnica.cocineta' => 'nullable|boolean',
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
