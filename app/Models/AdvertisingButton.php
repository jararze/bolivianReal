<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisingButton extends Model
{
    protected $guarded = [];

    public function advertising()
    {
        return $this->belongsTo(Advertising::class);
    }
}
