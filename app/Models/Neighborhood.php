<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Neighborhood extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
