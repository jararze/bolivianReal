<?php

namespace App\Http\Requests\Neighborhood;

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
        return [
            'name' => ['required', 'string', 'max:255',
                Rule::unique('neighborhoods', 'name')
                    ->where('city_id', $this->city_id)
                    ->ignore($this->route('neighborhood'))
            ],
            'city_id' => ['required', 'exists:cities,id'],
            'status' => ['required', 'boolean'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del barrio es obligatorio.',
            'name.unique' => 'Ya existe un barrio con este nombre en la ciudad seleccionada.',
            'city_id.required' => 'Debe seleccionar una ciudad.',
            'city_id.exists' => 'La ciudad seleccionada no es válida.',
            'status.required' => 'El estado es obligatorio.',
            'status.boolean' => 'El estado debe ser activo o inactivo.',
        ];
    }

}
