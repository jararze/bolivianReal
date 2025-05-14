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
        Schema::table('properties', function (Blueprint $table) {
            // Primero creamos la columna neighborhood_id
            $table->unsignedBigInteger('neighborhood_id')->nullable()->after('neighborhood')->index();

            // Añadimos la foreign key
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['neighborhood_id']);
            $table->dropColumn('neighborhood_id');
        });
    }
};
