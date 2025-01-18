<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $guarded = [];


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
}
