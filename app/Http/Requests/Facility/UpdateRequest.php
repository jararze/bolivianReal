<?php

namespace App\Http\Requests\Facility;

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
        $facility = $this->route('facility');
        $facilityId = $facility ? $facility->id : null;

        return [
            'name' => [
                'required',
                'max:100',
                Rule::unique('facilities', 'name')->ignore($facilityId),
            ],
            'icon' => 'nullable|string|max:255',
            'status' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}
