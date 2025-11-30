<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;


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
        'off_market_date' => 'datetime',
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

    /**
     * Obtener imágenes ordenadas por el número en el nombre del archivo
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOrderedImages()
    {
        // Obtener todas las imágenes de la propiedad
        $images = $this->images()->get();

        // Ordenar por el número en el nombre del archivo
        return $images->sort(function($a, $b) {
            $orderA = $this->extractOrderFromImageName($a->name);
            $orderB = $this->extractOrderFromImageName($b->name);

            return $orderA <=> $orderB;
        });
    }

    /**
     * Extraer orden del nombre de archivo guardado
     *
     * @param string $imagePath
     * @return int
     */
    private function extractOrderFromImageName(string $imagePath): int
    {
        $filename = basename($imagePath);

        // Buscar patrón como "01_", "02_", etc. al inicio del nombre
        if (preg_match('/^(\d{2})_/', $filename, $matches)) {
            return (int) $matches[1];
        }

        // Si no encuentra patrón, devolver 999 para que vaya al final
        return 999;
    }

    /**
     * Accessor para obtener imágenes ordenadas automáticamente
     * Opcional: si quieres que siempre devuelva las imágenes ordenadas
     */
    public function getImagesOrderedAttribute()
    {
        return $this->getOrderedImages();
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

    public function contracts()
    {
        return $this->hasMany(PropertyContract::class);
    }

    public function activeContract()
    {
        return $this->hasOne(PropertyContract::class)
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->latest('start_date');
    }

    public function activeContracts()
    {
        return $this->hasMany(PropertyContract::class)
            ->where('status', 'active')
            ->where('end_date', '>=', now());
    }

    public function hasActiveContract(): bool
    {
        return $this->activeContract()->exists();
    }

    public function latestContract()
    {
        return $this->hasOne(PropertyContract::class)
            ->latest('created_at');
    }


    public function scopeActive($query)
    {
        return $query->where('market_status', 'active');
    }

    public function scopeOffMarket($query)
    {
        return $query->where('market_status', 'off_market');
    }

    public function scopeWithActiveContracts($query)
    {
        return $query->whereHas('activeContract');
    }

    public function scopeWithExpiringContracts($query, $months = 3)
    {
        $futureDate = now()->addMonths($months);

        return $query->whereHas('activeContract', function ($q) use ($futureDate) {
            $q->where('end_date', '<=', $futureDate)
                ->where('end_date', '>=', now());
        });
    }


    public function hasExpiringContract(int $months = 3): bool
    {
        $contract = $this->activeContract;

        if (!$contract) {
            return false;
        }

        return $contract->isExpiringInMonths($months);
    }

    public function getDaysUntilContractExpiration(): ?int
    {
        $contract = $this->activeContract;

        if (!$contract) {
            return null;
        }

        return $contract->getDaysRemaining();
    }

    public function getOffMarketReasonLabel(): string
    {
        $reasons = [
            'sold' => 'Vendida',
            'rented' => 'Alquilada',
            'anticretico' => 'Anticrético',
            'owner_decision' => 'Decisión del propietario',
            'other' => 'Otro',
        ];

        return $reasons[$this->off_market_reason] ?? '-';
    }

    public function getMarketStatusBadgeClass(): string
    {
        return $this->market_status === 'active' ? 'badge-success' : 'badge-danger';
    }

    public function getMarketStatusLabel(): string
    {
        return $this->market_status === 'active' ? 'Activa' : 'Fuera de Mercado';
    }

    public function canHaveContract(): bool
    {
        // Solo propiedades de alquiler o anticrético pueden tener contratos
        // Ajusta esta lógica según tus service_types
        return in_array($this->service_type_id, [2, 3]); // Ejemplo: 2=Alquiler, 3=Anticrético
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

}
