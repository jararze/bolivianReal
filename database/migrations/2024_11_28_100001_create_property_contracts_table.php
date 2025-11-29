<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('property_contracts', function (Blueprint $table) {
            $table->id();
            
            // Relación con propiedad
            $table->foreignId('property_id')
                ->constrained('properties')
                ->onDelete('cascade');
            
            // Tipo de contrato
            $table->enum('contract_type', ['rent', 'anticretico'])
                ->default('rent')
                ->comment('Tipo: alquiler o anticrético');
            
            // Fechas del contrato
            $table->date('start_date')->comment('Fecha de inicio del contrato');
            $table->date('end_date')->comment('Fecha de finalización del contrato');
            $table->integer('duration_months')->comment('Duración en meses');
            
            // Información financiera
            $table->decimal('amount', 15, 2)->nullable()
                ->comment('Monto mensual (alquiler) o total (anticrético)');
            $table->enum('currency', ['Bs', '$us'])->default('Bs');
            
            // Datos del inquilino/arrendatario
            $table->string('tenant_name')->nullable();
            $table->string('tenant_phone', 50)->nullable();
            $table->string('tenant_email')->nullable();
            $table->string('tenant_ci', 50)->nullable()->comment('Carnet de identidad');
            $table->text('tenant_address')->nullable();
            
            // Notas y observaciones
            $table->text('notes')->nullable();
            
            // Estado del contrato
            $table->enum('status', ['active', 'expired', 'terminated', 'renewed'])
                ->default('active');
            
            // Sistema de alertas
            $table->boolean('alert_3months_sent')->default(false)
                ->comment('Alerta 3 meses antes enviada');
            $table->datetime('alert_3months_sent_at')->nullable();
            
            $table->boolean('alert_1month_sent')->default(false)
                ->comment('Alerta 1 mes antes enviada');
            $table->datetime('alert_1month_sent_at')->nullable();
            
            $table->boolean('alert_1week_sent')->default(false)
                ->comment('Alerta 1 semana antes enviada');
            $table->datetime('alert_1week_sent_at')->nullable();
            
            // Datos de renovación (si aplica)
            $table->foreignId('renewed_from_contract_id')->nullable()
                ->comment('ID del contrato anterior si es renovación');
            $table->foreignId('renewed_to_contract_id')->nullable()
                ->comment('ID del nuevo contrato si se renovó');
            
            // Auditoría
            $table->foreignId('created_by')->nullable()
                ->comment('Usuario que creó el contrato');
            $table->foreignId('updated_by')->nullable()
                ->comment('Usuario que actualizó el contrato');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('property_id');
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
            $table->index(['property_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_contracts');
    }
};
