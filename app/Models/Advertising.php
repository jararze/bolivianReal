<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertising extends Model
{
    use softDeletes;

    protected $guarded = [];


    public function buttons()
    {
        return $this->hasMany(AdvertisingButton::class);
    }

}
