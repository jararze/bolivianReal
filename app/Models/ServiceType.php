<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceType extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function properties()
    {
        return $this->hasMany(Property::class, 'service_type_id');
    }
}
