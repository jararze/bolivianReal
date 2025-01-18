<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;


    protected $guarded = [];

    protected $casts = [
        'data' => 'array', // Cast automático para manejar JSON
        'read_at' => 'datetime',
    ];
}
