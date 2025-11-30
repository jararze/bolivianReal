<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'jobtitle',
        'username',
        'email',
        'password',
        'photo',
        'phone',
        'address',
        'city',
        'country',
        'aboutme',
        'package_id',
        'package_status',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relaciones
     */

    // Paquete asociado al usuario
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Propiedades creadas por este usuario (como agente)
    public function properties()
    {
        return $this->hasMany(Property::class, 'agent_id');
    }

    // Clientes creados por este usuario
    public function createdClients()
    {
        return $this->hasMany(Client::class, 'created_by');
    }

    // Contratos creados por este usuario
    public function createdContracts()
    {
        return $this->hasMany(PropertyContract::class, 'created_by');
    }

    /**
     * Accessors
     */

    // Nombre completo
    public function getFullNameAttribute(): string
    {
        return trim($this->name . ' ' . $this->lastname);
    }

    /**
     * Scopes
     */

    // Usuarios activos
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Usuarios inactivos
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    // Solo agentes
    public function scopeAgents($query)
    {
        return $query->where('role', 'agent');
    }

    // Solo admins
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // Buscar por nombre, email o username
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('lastname', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%");
        });
    }

    /**
     * Helper Methods
     */

    // Verificar si es admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Verificar si es agente
    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    // Verificar si está activo
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // Obtener foto o avatar por defecto
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }

        // Avatar con iniciales
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . '&background=random';
    }
}
