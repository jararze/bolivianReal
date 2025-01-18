<?php

namespace App\Http\Requests\Configuration;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppearanceRequest extends FormRequest
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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120', // Increased to 5MB
            'logo_internal' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Increased to 4MB
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Kept at 2MB
            'site_name' => 'required|string|max:255',
            'primary_color' => 'required|string|max:7|regex:/^#([A-Fa-f0-9]{6})$/',
            'secondary_color' => 'required|string|max:7|regex:/^#([A-Fa-f0-9]{6})$/',
            'support_color' => 'required|string|max:7|regex:/^#([A-Fa-f0-9]{6})$/',
        ];
    }

    public function messages(): array
    {
        return [
            'logo.image' => 'El logo debe ser una imagen',
            'logo.mimes' => 'El logo debe ser de tipo: jpeg, png, jpg, gif, svg',
            'logo.max' => 'El logo no debe pesar más de 5MB',

            'logo_internal.image' => 'El logo interno debe ser una imagen',
            'logo_internal.mimes' => 'El logo interno debe ser de tipo: jpeg, png, jpg, gif, svg',
            'logo_internal.max' => 'El logo interno no debe pesar más de 4MB',

            'favicon.image' => 'El favicon debe ser una imagen',
            'favicon.mimes' => 'El favicon debe ser de tipo: jpeg, png, jpg, gif, svg',
            'favicon.max' => 'El favicon no debe pesar más de 2MB',

            'site_name.required' => 'El nombre del sitio es requerido',
            'site_name.max' => 'El nombre del sitio no debe exceder los 255 caracteres',

            'primary_color.required' => 'El color primario es requerido',
            'primary_color.regex' => 'El color primario debe ser un código hexadecimal válido',

            'secondary_color.required' => 'El color secundario es requerido',
            'secondary_color.regex' => 'El color secundario debe ser un código hexadecimal válido',

            'support_color.required' => 'El color de apoyo es requerido',
            'support_color.regex' => 'El color de apoyo debe ser un código hexadecimal válido',
        ];
    }

}
