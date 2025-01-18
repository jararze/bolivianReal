<?php

namespace App\Http\Requests\Configuration;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHomeSliderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'property_ids' => 'required|array',
            'property_ids.*' => 'exists:properties,id',
            'active' => 'boolean',
            'order' => 'in:asc,desc'
        ];
    }

    public function messages(): array
    {
        return [
            'property_ids.required' => 'Debe seleccionar al menos una propiedad',
            'property_ids.array' => 'El formato de las propiedades no es válido',
            'property_ids.*.exists' => 'Una de las propiedades seleccionadas no existe'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
