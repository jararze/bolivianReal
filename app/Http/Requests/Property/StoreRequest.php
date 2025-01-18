<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Validator;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'size' => ['required', 'numeric'],
            'size_max' => ['required', 'numeric'],
            'city' => ['required', 'exists:cities,id'],
            'country' => ['required', 'string', 'max:255'],
            'propertytype_id' => ['required', 'exists:property_types,id'],
            'service_type_id' => ['required', 'exists:service_types,id'],
            'currency' => ['required'],
            'chosen_currency' => ['required', 'boolean'],
            'lowest_price' => ['required', 'numeric'],
            'max_price' => ['required', 'numeric'],
            'bedrooms' => ['required', 'integer'],
            'bathrooms' => ['required', 'integer'],
            'garage' => ['required', 'integer'],
            'garage_size' => ['required', 'numeric'],
            'short_description' => ['required', 'string'],
            'long_description' => ['required', 'string'],
            'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120', 'dimensions:min_width=800,min_height=600'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048', 'dimensions:min_width=800,min_height=600'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'features' => ['nullable', 'array'],
            'features.*' => ['exists:facilities,id'],
            'place_names' => ['nullable', 'array'],
            'place_names.*' => ['string', 'max:255'],
            'distances' => ['nullable', 'array'],
            'distances.*' => ['string', 'max:255'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['exists:amenities,id'],
            'video' => ['nullable', 'url'],
            'featured' => ['nullable', 'boolean'],
            'hot' => ['nullable', 'boolean'],
            'agent_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'boolean'],
            'is_project' => ['required', 'boolean'],
            'units' => ['nullable', 'required_if:is_project,1', 'integer'],
            'project_id' => ['nullable', 'exists:properties,id'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Log todos los datos recibidos
        Log::channel('daily')->info('Datos recibidos en StoreRequest:', [
            'all_data' => $this->all(),
            'files' => $this->allFiles()
        ]);

        // Log errores de validación
        Log::channel('daily')->error('Errores de validación en StoreRequest:', [
            'errors' => $validator->errors()->toArray(),
            'failed_rules' => $validator->failed()
        ]);

        parent::failedValidation($validator);
    }

    protected function prepareForValidation()
    {
        // Log antes de la preparación
        Log::channel('daily')->info('Datos antes de preparación:', [
            'raw_data' => $this->all()
        ]);

        // Convertir strings 'true'/'false' a booleanos para campos boolean
        $booleanFields = ['currency', 'chosen_currency', 'featured', 'hot', 'status', 'is_project'];

        foreach ($booleanFields as $field) {
            if ($this->has($field)) {
                $value = $this->input($field);
                if (is_string($value)) {
                    $this->merge([
                        $field => in_array(strtolower($value), ['true', '1', 'on', 'yes'])
                    ]);
                }
            }
        }

        // Log después de la preparación
        Log::channel('daily')->info('Datos después de preparación:', [
            'prepared_data' => $this->all()
        ]);
    }

    public function messages(): array
    {
        return [
            'lowest_price.required' => 'El precio mínimo es requerido',
            'short_description.required' => 'La descripción corta es requerida',
            'long_description.required' => 'La descripción larga es requerida',
            'propertytype_id.required' => 'El tipo de propiedad es requerido',
            'propertytype_id.exists' => 'El tipo de propiedad seleccionado no es válido',
            'agent_id.required' => 'El agente es requerido',
            'agent_id.exists' => 'El agente seleccionado no es válido',
            'thumbnail.required' => 'La imagen principal es obligatoria.',
            'thumbnail.image' => 'El archivo debe ser una imagen.',
            'thumbnail.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg.',
            'thumbnail.max' => 'La imagen no debe pesar más de 2MB.',
            'thumbnail.dimensions' => 'La imagen debe tener al menos 800x600 píxeles.',
            'images.required' => 'Debe subir al menos una imagen de la propiedad',
            'images.min' => 'Debe subir al menos una imagen de la propiedad',
            'images.*.required' => 'Todas las imágenes son requeridas',
            'images.*.image' => 'Todos los archivos deben ser imágenes',
            'images.*.max' => 'Las imágenes no deben pesar más de 2MB',
            'latitude.between' => 'La latitud debe estar entre -90 y 90',
            'longitude.between' => 'La longitud debe estar entre -180 y 180',
            'currency.in' => 'La moneda seleccionada no es válida. Debe ser Bs o $us.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
