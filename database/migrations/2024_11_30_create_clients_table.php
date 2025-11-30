<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable()->index();
            $table->string('phone_secondary')->nullable();
            $table->string('ci')->nullable()->unique(); // Cédula de Identidad
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->text('notes')->nullable();
            $table->enum('client_type', ['owner', 'buyer', 'tenant', 'both'])->default('owner'); // Propietario, Comprador, Inquilino
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Agregar campo client_id a properties
        Schema::table('properties', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->after('agent_id')->index();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
        
        Schema::dropIfExists('clients');
    }
};
