<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsCollection;

class Configuration extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'value' => AsCollection::class,
        'metadata' => AsCollection::class,
        'status' => 'boolean'
    ];

    public static function getConfig(string $key, $default = null)
    {
        $config = static::where('key', $key)
            ->where('status', true)
            ->first();
        return $config ? $config->value : $default;
    }

    public static function setConfig(string $key, $value, ?string $group = null, ?array $metadata = null): self
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'metadata' => $metadata ?? [],
                'status' => true
            ]
        );
    }

    // Scope for active configurations
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    public static function disableConfig(string $key): bool
    {
        $config = static::where('key', $key)->first();
        if ($config) {
            $config->status = false;
            return $config->save();
        }
        return false;
    }

    // Get all configurations by group
    public static function getConfigsByGroup(string $group)
    {
        return static::active()
            ->where('group', $group)
            ->get()
            ->pluck('value', 'key');
    }


}
