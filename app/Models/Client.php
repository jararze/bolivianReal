<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
        'phone_secondary',
        'ci',
        'address',
        'city',
        'notes',
        'client_type',
        'status',
        'created_by',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Relaciones
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessor
    public function getFullNameAttribute(): string
    {
        return trim($this->name . ' ' . $this->lastname);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('lastname', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%")
              ->orWhere('ci', 'LIKE', "%{$search}%");
        });
    }
}
