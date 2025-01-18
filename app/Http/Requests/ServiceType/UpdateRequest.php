<?php

namespace App\Http\Requests\ServiceType;

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
        $serviceType = $this->route('service_type');
        $serviceId = $serviceType ? $serviceType->id : null;
        return [
            'name' => [
                'required',
                'max:100',
                Rule::unique('service_types', 'name')->ignore($serviceId),
            ],
            'status' => 'nullable|string',
        ];
    }
}
