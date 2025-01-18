<?php

namespace App\Http\Requests\Package;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|unique:packages|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|integer',
            'duration' => 'nullable|integer',
            'credits' => 'nullable|integer',
            'front_display' => 'nullable|string',
            'status' => 'nullable|string',
        ];
    }
}
