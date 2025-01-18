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
        Schema::create('advertisings', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150); // Título del anuncio
            $table->text('content'); // Contenido del anuncio
            $table->string('image_path', 255)->nullable(); // Ruta de la imagen opcional
            $table->boolean('status')->default(1)->index(); // Estado activo/inactivo
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('advertising_buttons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advertising_id'); // Relación con la tabla advertisings
            $table->string('label'); // Texto del botón
            $table->string('icon')->nullable(); // Icono del botón
            $table->string('link')->nullable(); // Enlace del botón
            $table->timestamps();
            $table->softDeletes(); // Para eliminación lógica

            // Llave foránea
            $table->foreign('advertising_id')->references('id')->on('advertisings')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisings');
        Schema::dropIfExists('advertising_buttons');
    }
};
