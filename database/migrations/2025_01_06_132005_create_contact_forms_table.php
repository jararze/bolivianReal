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
        Schema::create('contact_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Nombre del remitente
            $table->string('email', 150); // Correo electrónico
            $table->string('phone', 150); // Correo electrónico
            $table->string('subject', 150)->nullable(); // Asunto del mensaje
            $table->text('message'); // Contenido del mensaje
            $table->boolean('response')->default(0)->index(); // Estado (leído/no leído)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_forms');
    }
};
