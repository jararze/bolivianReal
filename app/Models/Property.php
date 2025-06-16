<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Property extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $appends = ['thumbnail_url'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_project' => 'boolean',
        'featured' => 'boolean',
        'hot' => 'boolean',
        'status' => 'boolean',
        'chosen_currency' => 'boolean',
        'delivery' => 'datetime',
        'construction_Date' => 'datetime',
    ];




    /**
     * Relationships
     */

    public function getThumbnailUrlAttribute()
    {
        try {
            // Si no hay thumbnail, retorna el placeholder
            if (empty($this->thumbnail)) {
                return asset('images/no-image.jpg');
            }

            // Construye la URL pública
            $publicPath = 'storage/properties/images/' . $this->thumbnail;

            // Verifica si el archivo existe físicamente
            if (file_exists(public_path($publicPath))) {
                return asset($publicPath);
            }

            // Si el archivo no existe, retorna el placeholder
            return asset('images/no-image.jpg');

        } catch (\Exception $e) {
            Log::error('Error getting thumbnail:', [
                'property_id' => $this->id,
                'error' => $e->getMessage()
            ]);
            return asset('images/no-image.jpg');
        }
    }

    // Método para debug
    public function debugImagePaths()
    {
        $imagePath = str_replace('\\', '/', $this->image);
        $fullPath = 'public/properties/images/' . basename($imagePath);

        return [
            'original_image' => $this->image,
            'normalized_path' => $imagePath,
            'full_storage_path' => storage_path('app/' . $fullPath),
            'exists_in_storage' => Storage::exists($fullPath),
            'public_url' => asset('storage/properties/images/' . basename($imagePath)),
        ];
    }


    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class, 'propertytype_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function citys()
    {
        return $this->belongsTo(City::class, 'city');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'facility_properties')
            ->withPivot('name', 'distance')
            ->withTimestamps();
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'amenity_property')
        ->withTimestamps();
    }
    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function whatcity()
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }

    public function neighborhoodRelation()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id');
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id');
    }


}
