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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID como clave primaria
            $table->string('type'); // Tipo de notificación
            $table->morphs('notifiable'); // Polimorfismo para asociar a diferentes modelos
            $table->json('data'); // Uso de JSON para almacenar datos estructurados
            $table->timestamp('read_at')->nullable(); // Marca de tiempo para notificaciones leídas
            $table->timestamps(); // Timestamps estándar de Laravel
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
