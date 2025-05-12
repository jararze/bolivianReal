<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'size' => 'required|numeric',
            'size_max' => 'nullable|numeric',
            'city' => 'required',
            'country' => 'required|string|max:255',
            'propertytype_id' => 'required|exists:property_types,id',
            'service_type_id' => 'required|exists:service_types,id',
            'currency' => 'required|string|in:Bs,$us',
            'chosen_currency' => 'nullable|boolean',
            'lowest_price' => 'required|numeric',
            'max_price' => 'nullable|numeric',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'garage' => 'nullable|integer',
            'garage_size' => 'nullable|numeric',
            'short_description' => 'required|string|max:255',
            'long_description' => 'nullable|string',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|url',
            'featured' => 'nullable|boolean',
            'hot' => 'nullable|boolean',
            'agent_id' => 'nullable|exists:users,id',
            'status' => 'nullable|boolean',
            'is_project' => 'nullable|boolean',
            'units' => 'nullable|integer',
            'project_id' => 'nullable|exists:properties,id',
            'features' => 'nullable|array',
            'features.*' => 'exists:facilities,id',
            'place_names' => 'nullable|array',
            'place_names.*' => 'nullable|string',
            'distances' => 'nullable|array',
            'distances.*' => 'nullable|string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'remove_thumbnail' => 'nullable|boolean',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'nullable|boolean',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
