<?php

namespace App\Http\Requests\Gestion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAsignacionEquipoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'inmueble_id' => [
                'required',
                'integer',
                Rule::exists('inmuebles', 'id')->whereNull('deleted_at'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'inmueble_id.required' => 'Debe seleccionar un inmueble.',
            'inmueble_id.exists' => 'El inmueble seleccionado no existe o ha sido eliminado.',
        ];
    }
}
