<?php

namespace App\Http\Requests\Configuration;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHomeInfoRequest extends FormRequest
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
            'refresh_time' => 'required|integer|min:1|max:60',
            'video_url' => 'nullable|url|max:255',
            'upload_property_title' => 'required|string|max:255',
            'upload_property_description' => 'required|string|max:500',
            'steps' => 'required|array|min:1',
            'steps.*.title' => 'required|string|max:100',
            'steps.*.description' => 'required|string|max:255',
            'steps.*.icon' => 'required|string|max:50'
        ];
    }

    public function messages(): array
    {
        return [
            'refresh_time.required' => 'El tiempo de refresco es obligatorio',
            'refresh_time.integer' => 'El tiempo debe ser un número entero',
            'refresh_time.min' => 'El tiempo mínimo es 1 segundo',
            'refresh_time.max' => 'El tiempo máximo es 60 segundos',
            'video_url.url' => 'La URL del video debe ser válida',
            'upload_property_title.required' => 'El título es obligatorio',
            'upload_property_description.required' => 'La descripción es obligatoria',
            'steps.required' => 'Los pasos son obligatorios',
            'steps.*.title.required' => 'El título del paso es obligatorio',
            'steps.*.description.required' => 'La descripción del paso es obligatoria',
            'steps.*.icon.required' => 'El ícono del paso es obligatorio'
        ];
    }
}
