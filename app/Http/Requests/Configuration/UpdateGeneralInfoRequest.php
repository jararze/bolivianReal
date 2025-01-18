<?php

namespace App\Http\Requests\Configuration;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'direction' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'attentionHour' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la compañía es requerido',
            'phone.required' => 'El teléfono es requerido',
            'direction.required' => 'La dirección es requerida',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email debe ser válido',
            'attentionHour.required' => 'El horario de atención es requerido',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
