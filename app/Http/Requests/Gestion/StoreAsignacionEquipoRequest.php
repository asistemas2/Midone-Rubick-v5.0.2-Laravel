<?php

namespace App\Http\Requests\Gestion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAsignacionEquipoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'equipo_id' => [
                'required',
                'integer',
                Rule::exists('equipos', 'id')->whereNull('deleted_at'),
            ],
            'inmueble_id' => [
                'required',
                'integer',
                Rule::exists('inmuebles', 'id')->whereNull('deleted_at'),
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->filled('equipo_id')) {
                $equipo = \App\Models\Equipo::find($this->equipo_id);
                if ($equipo && !is_null($equipo->inmueble_id)) {
                    $validator->errors()->add(
                        'equipo_id',
                        'Este equipo ya está asignado a un inmueble. Debe desasignarlo primero o usar la opción de reasignar.'
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'equipo_id.required' => 'Debe seleccionar un equipo.',
            'equipo_id.exists' => 'El equipo seleccionado no existe o ha sido eliminado.',
            'inmueble_id.required' => 'Debe seleccionar un inmueble.',
            'inmueble_id.exists' => 'El inmueble seleccionado no existe o ha sido eliminado.',
        ];
    }
}
