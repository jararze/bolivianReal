<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Validator;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'neighborhood_id' => ['required', 'exists:neighborhoods,id'],
            'size' => ['nullable', 'numeric'],
            'size_max' => ['nullable', 'numeric'],
            'city' => ['required', 'exists:cities,id'],
            'country' => ['required', 'string', 'max:255'],
            'propertytype_id' => ['required', 'exists:property_types,id'],
            'service_type_id' => ['required', 'exists:service_types,id'],
            'currency' => ['required', 'string', 'in:Bs,$us'],
//            'chosen_currency' => ['required', 'boolean'],
            'lowest_price' => ['required', 'numeric'],
            'max_price' => ['nullable', 'numeric'],
            'bedrooms' => ['required', 'integer'],
            'bathrooms' => ['required', 'integer'],
            'garage' => ['nullable', 'integer'],
            'garage_size' => ['nullable', 'numeric'],
            'short_description' => ['required', 'string'],
            'long_description' => ['required', 'string'],
            'latitude' => ['nullable', 'string'],
            'longitude' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120', 'dimensions:min_width=600,min_height=400'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048', 'dimensions:min_width=600,min_height=400'],
            'video' => ['nullable', 'url'],
            'featured' => ['nullable', 'boolean'],
            'hot' => ['nullable', 'boolean'],
            'agent_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'boolean'],
            'is_project' => ['required', 'boolean'],
            'units' => ['nullable', 'required_if:is_project,1', 'integer'],
            'project_id' => ['nullable', 'exists:properties,id'],

            // Validación mejorada para servicios cercanos
            'features' => ['nullable', 'array'],
            'features.*' => ['nullable', 'exists:facilities,id'],
            'place_names' => ['nullable', 'array'],
            'place_names.*' => ['nullable', 'string', 'max:255'],
            'distances' => ['nullable', 'array'],
            'distances.*' => ['nullable', 'string', 'max:100'],

            // Amenidades
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['exists:amenities,id'],

            // Campos para manejo de imágenes
            'remove_thumbnail' => ['nullable', 'boolean'],
            'delete_images' => ['nullable', 'array'],
            'delete_images.*' => ['nullable', 'boolean'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Log todos los datos recibidos
        Log::channel('daily')->info('Datos recibidos en UpdateRequest:', [
            'all_data' => $this->all(),
            'files' => $this->allFiles()
        ]);

        // Log errores de validación
        Log::channel('daily')->error('Errores de validación en UpdateRequest:', [
            'errors' => $validator->errors()->toArray(),
            'failed_rules' => $validator->failed()
        ]);

        parent::failedValidation($validator);
    }

    protected function prepareForValidation()
    {
        // Log antes de la preparación
        Log::channel('daily')->info('Datos antes de preparación (Update):', [
            'raw_data' => $this->all()
        ]);

        // Limpiar arrays de servicios vacíos
        if ($this->has('features')) {
            $features = array_filter($this->features ?? [], function($value) {
                return !empty($value) && is_numeric($value);
            });

            $placeNames = [];
            $distances = [];

            // Reorganizar arrays manteniendo solo los índices válidos
            $originalFeatures = $this->features ?? [];
            $originalPlaceNames = $this->place_names ?? [];
            $originalDistances = $this->distances ?? [];

            foreach ($originalFeatures as $index => $featureId) {
                if (!empty($featureId) && is_numeric($featureId)) {
                    $placeNames[] = $originalPlaceNames[$index] ?? '';
                    $distances[] = $originalDistances[$index] ?? '';
                }
            }

            $this->merge([
                'features' => array_values($features),
                'place_names' => $placeNames,
                'distances' => $distances,
            ]);
        }

        // Convertir strings 'true'/'false' a booleanos para campos boolean
        $booleanFields = ['featured', 'hot', 'status', 'is_project', 'remove_thumbnail'];

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
        Log::channel('daily')->info('Datos después de preparación (Update):', [
            'prepared_data' => $this->all()
        ]);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser texto',
            'name.max' => 'El nombre no debe exceder los 255 caracteres',

            'address.required' => 'La dirección es requerida',
            'address.string' => 'La dirección debe ser texto',
            'address.max' => 'La dirección no debe exceder los 255 caracteres',

            'neighborhood_id.required' => 'La zona es requerida',
            'neighborhood_id.exists' => 'La zona seleccionada no es válida',

            'size.numeric' => 'La superficie del terreno debe ser un número',
            'size_max.numeric' => 'La superficie construida debe ser un número',

            'city.required' => 'La ciudad es requerida',
            'city.exists' => 'La ciudad seleccionada no es válida',

            'country.required' => 'El país es requerido',
            'country.string' => 'El país debe ser texto',
            'country.max' => 'El país no debe exceder los 255 caracteres',

            'propertytype_id.required' => 'El tipo de propiedad es requerido',
            'propertytype_id.exists' => 'El tipo de propiedad seleccionado no es válido',

            'service_type_id.required' => 'El tipo de servicio es requerido',
            'service_type_id.exists' => 'El tipo de servicio seleccionado no es válido',

            'currency.required' => 'La moneda es requerida',
            'currency.in' => 'La moneda seleccionada no es válida. Debe ser Bs o $us.',

//            'chosen_currency.required' => 'Debe seleccionar la moneda a mostrar',
//            'chosen_currency.boolean' => 'El valor de moneda a mostrar no es válido',

            'lowest_price.required' => 'El precio mínimo es requerido',
            'lowest_price.numeric' => 'El precio mínimo debe ser un número',

            'max_price.numeric' => 'El precio máximo debe ser un número',

            'bedrooms.required' => 'El número de habitaciones es requerido',
            'bedrooms.integer' => 'El número de habitaciones debe ser un número entero',

            'bathrooms.required' => 'El número de baños es requerido',
            'bathrooms.integer' => 'El número de baños debe ser un número entero',

            'garage.integer' => 'El número de espacios en el garaje debe ser un número entero',
            'garage_size.numeric' => 'La superficie del garaje debe ser un número',

            'short_description.required' => 'La descripción corta es requerida',
            'short_description.string' => 'La descripción corta debe ser texto',

            'long_description.required' => 'La descripción larga es requerida',
            'long_description.string' => 'La descripción larga debe ser texto',

            'thumbnail.image' => 'El archivo debe ser una imagen',
            'thumbnail.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg',
            'thumbnail.max' => 'La imagen no debe pesar más de 5MB',
            'thumbnail.dimensions' => 'La imagen debe tener al menos 600x400 píxeles',

            'images.*.image' => 'Todos los archivos deben ser imágenes',
            'images.*.mimes' => 'Las imágenes deben ser de tipo: jpeg, png, jpg',
            'images.*.max' => 'Las imágenes no deben pesar más de 2MB',
            'images.*.dimensions' => 'Las imágenes deben tener al menos 600x400 píxeles',

            'latitude.numeric' => 'La latitud debe ser un número',
            'longitude.numeric' => 'La longitud debe ser un número',

            'features.array' => 'El formato de los servicios cercanos no es válido',
            'features.*.exists' => 'Uno de los servicios cercanos seleccionados no es válido',

            'place_names.array' => 'El formato de los nombres de lugares no es válido',
            'place_names.*.string' => 'Los nombres de lugares deben ser texto',
            'place_names.*.max' => 'Los nombres de lugares no deben exceder los 255 caracteres',

            'distances.array' => 'El formato de las distancias no es válido',
            'distances.*.string' => 'Las distancias deben ser texto',
            'distances.*.max' => 'Las distancias no deben exceder los 100 caracteres',

            'amenities.array' => 'El formato de las amenidades no es válido',
            'amenities.*.exists' => 'Una de las amenidades seleccionadas no es válida',

            'video.url' => 'La URL del video no es válida',

            'agent_id.exists' => 'El agente seleccionado no es válido',

            'status.required' => 'El estado es requerido',
            'status.boolean' => 'El valor del estado no es válido',

            'is_project.required' => 'Debe indicar si es un proyecto',
            'is_project.boolean' => 'El valor de proyecto no es válido',

            'units.required_if' => 'El número de unidades es requerido cuando es un proyecto',
            'units.integer' => 'El número de unidades debe ser un número entero',

            'project_id.exists' => 'El proyecto seleccionado no es válido'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
