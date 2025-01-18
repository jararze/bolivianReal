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
        Schema::create('testimonies', function (Blueprint $table) {
            $table->id();
            $table->string('author', 100); // Nombre del autor
            $table->string('job', 100)->nullable(); // Profesión u ocupación del autor
            $table->text('content'); // Contenido del testimonio
            $table->string('image_path', 255)->nullable(); // Ruta de la imagen opcional
            $table->boolean('status')->default(1)->index(); // Estado activo/inactivo
            $table->timestamps();
            $table->softDeletes(); // Soft Deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonies');
    }
};
