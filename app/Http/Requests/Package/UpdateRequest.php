<?php

namespace App\Http\Requests\Package;

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
            'name' => [
                'required',
                'max:255',
                Rule::unique('packages', 'name')->ignore($this->route('package')->id),
            ],
            'description' => 'nullable|string',
            'price' => ['nullable', 'regex:/^\d+(\.\d{1,4})?$/'],
            'duration' => 'nullable|integer',
            'credits' => 'nullable|integer',
            'front_display' => 'nullable|string',
            'status' => 'nullable|string',
        ];
    }
}
