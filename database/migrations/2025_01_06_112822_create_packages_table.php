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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique(); // Nombre del paquete, único
            $table->decimal('price', 10, 2); // Precio del paquete
            $table->integer('duration'); // Duración en días
            $table->integer('credits')->default(0); // Créditos asignados al paquete
            $table->boolean('front_display')->default(0); // Mostrar en el frontend
            $table->text('description')->nullable(); // Descripción opcional
            $table->boolean('status')->default(1)->index(); // Estado activo/inactivo con índice
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
