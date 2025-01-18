<?php

namespace App\Http\Requests\PropertyType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Accede al parámetro de la ruta correctamente
        $propertyType = $this->route('property_type');
        $propertyTypeId = $propertyType ? $propertyType->id : null;

        return [
            'type_name' => [
                'required',
                'max:100',
                Rule::unique('property_types', 'type_name')->ignore($propertyTypeId),
            ],
            'type_icon' => 'nullable|string|max:255',
            'status' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}
