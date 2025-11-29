<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class PropertyContract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'property_id',
        'contract_type',
        'start_date',
        'end_date',
        'duration_months',
        'amount',
        'currency',
        'tenant_name',
        'tenant_phone',
        'tenant_email',
        'tenant_ci',
        'tenant_address',
        'notes',
        'status',
        'alert_3months_sent',
        'alert_3months_sent_at',
        'alert_1month_sent',
        'alert_1month_sent_at',
        'alert_1week_sent',
        'alert_1week_sent_at',
        'renewed_from_contract_id',
        'renewed_to_contract_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'amount' => 'decimal:2',
        'alert_3months_sent' => 'boolean',
        'alert_3months_sent_at' => 'datetime',
        'alert_1month_sent' => 'boolean',
        'alert_1month_sent_at' => 'datetime',
        'alert_1week_sent' => 'boolean',
        'alert_1week_sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relaciones
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function renewedFrom()
    {
        return $this->belongsTo(PropertyContract::class, 'renewed_from_contract_id');
    }

    public function renewedTo()
    {
        return $this->belongsTo(PropertyContract::class, 'renewed_to_contract_id');
    }

    /**
     * Scopes
     */

    // Contratos activos
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('end_date', '>=', now());
    }

    // Contratos expirados
    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now())
            ->where('status', '!=', 'terminated');
    }

    // Contratos que vencen pronto
    public function scopeExpiringIn($query, $months = 3)
    {
        $futureDate = now()->addMonths($months);

        return $query->where('status', 'active')
            ->where('end_date', '<=', $futureDate)
            ->where('end_date', '>=', now());
    }

    // Contratos de alquiler
    public function scopeRent($query)
    {
        return $query->where('contract_type', 'rent');
    }

    // Contratos de anticrético
    public function scopeAnticretico($query)
    {
        return $query->where('contract_type', 'anticretico');
    }

    /**
     * Métodos Helper
     */

    // Verificar si el contrato está activo
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->end_date >= now();
    }

    // Verificar si el contrato ya expiró
    public function isExpired(): bool
    {
        return $this->end_date < now();
    }

    // Obtener días restantes
    public function getDaysRemaining(): int
    {
        if ($this->isExpired()) {
            return 0;
        }

        return now()->diffInDays($this->end_date, false);
    }

    // Obtener meses restantes
    public function getMonthsRemaining(): int
    {
        if ($this->isExpired()) {
            return 0;
        }

        return now()->diffInMonths($this->end_date, false);
    }

    // Verificar si vence en X meses o menos
    public function isExpiringInMonths(int $months = 3): bool
    {
        if ($this->isExpired()) {
            return false;
        }

        $futureDate = now()->addMonths($months);
        return $this->end_date <= $futureDate;
    }

    // Verificar si necesita alerta de 3 meses
    public function needsThreeMonthAlert(): bool
    {
        return $this->isExpiringInMonths(3)
            && !$this->alert_3months_sent
            && $this->status === 'active';
    }

    // Verificar si necesita alerta de 1 mes
    public function needsOneMonthAlert(): bool
    {
        return $this->isExpiringInMonths(1)
            && !$this->alert_1month_sent
            && $this->status === 'active';
    }

    // Verificar si necesita alerta de 1 semana
    public function needsOneWeekAlert(): bool
    {
        $oneWeekFromNow = now()->addWeek();

        return $this->end_date <= $oneWeekFromNow
            && $this->end_date >= now()
            && !$this->alert_1week_sent
            && $this->status === 'active';
    }

    // Marcar alerta de 3 meses como enviada
    public function markThreeMonthAlertSent(): void
    {
        $this->update([
            'alert_3months_sent' => true,
            'alert_3months_sent_at' => now(),
        ]);
    }

    // Marcar alerta de 1 mes como enviada
    public function markOneMonthAlertSent(): void
    {
        $this->update([
            'alert_1month_sent' => true,
            'alert_1month_sent_at' => now(),
        ]);
    }

    // Marcar alerta de 1 semana como enviada
    public function markOneWeekAlertSent(): void
    {
        $this->update([
            'alert_1week_sent' => true,
            'alert_1week_sent_at' => now(),
        ]);
    }

    // Obtener etiqueta del tipo de contrato
    public function getContractTypeLabel(): string
    {
        return $this->contract_type === 'rent' ? 'Alquiler' : 'Anticrético';
    }

    // Obtener etiqueta del estado
    public function getStatusLabel(): string
    {
        $statuses = [
            'active' => 'Activo',
            'expired' => 'Expirado',
            'terminated' => 'Terminado',
            'renewed' => 'Renovado',
        ];

        return $statuses[$this->status] ?? 'Desconocido';
    }

    // Obtener clase de badge según estado
    public function getStatusBadgeClass(): string
    {
        $classes = [
            'active' => 'badge-success',
            'expired' => 'badge-danger',
            'terminated' => 'badge-gray',
            'renewed' => 'badge-info',
        ];

        return $classes[$this->status] ?? 'badge-gray';
    }

    // Formatear monto con moneda
    public function getFormattedAmount(): string
    {
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    // Renovar contrato (crear uno nuevo basado en el actual)
    public function renew(array $data = []): PropertyContract
    {
        $newContract = $this->replicate([
            'id',
            'created_at',
            'updated_at',
            'deleted_at',
            'alert_3months_sent',
            'alert_3months_sent_at',
            'alert_1month_sent',
            'alert_1month_sent_at',
            'alert_1week_sent',
            'alert_1week_sent_at',
        ]);

        // Actualizar fechas
        $newContract->start_date = $data['start_date'] ?? $this->end_date->copy()->addDay();
        $newContract->duration_months = (int) ($data['duration_months'] ?? $this->duration_months); // ← CAST A INT
        $newContract->end_date = \Carbon\Carbon::parse($newContract->start_date)->addMonths($newContract->duration_months); // ← USAR Carbon::parse

        // Actualizar otros datos si se proporcionan
        if (isset($data['amount'])) {
            $newContract->amount = $data['amount'];
        }
        if (isset($data['notes'])) {
            $newContract->notes = $data['notes'];
        }

        // Establecer relaciones
        $newContract->renewed_from_contract_id = $this->id;
        $newContract->status = 'active';
        $newContract->created_by = auth()->id();

        $newContract->save();

        // Actualizar el contrato actual
        $this->update([
            'status' => 'renewed',
            'renewed_to_contract_id' => $newContract->id,
        ]);

        return $newContract;
    }

    // Terminar contrato anticipadamente
    public function terminate(string $reason = null): void
    {
        $this->update([
            'status' => 'terminated',
            'notes' => $this->notes . "\n\nTerminado: " . $reason,
        ]);
    }

    /**
     * Eventos del modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Al crear, calcular la fecha de fin automáticamente si no se proporciona
        static::creating(function ($contract) {
            if (empty($contract->end_date) && !empty($contract->start_date) && !empty($contract->duration_months)) {
                $contract->end_date = Carbon::parse($contract->start_date)
                    ->addMonths($contract->duration_months);
            }

            if (empty($contract->created_by)) {
                $contract->created_by = auth()->id();
            }
        });

        // Al actualizar, registrar quién lo hizo
        static::updating(function ($contract) {
            $contract->updated_by = auth()->id();
        });
    }
}
