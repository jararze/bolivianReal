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
        Schema::create('facility_properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id')->index(); // Index added
            $table->unsignedBigInteger('facility_id')->index(); // Index added
            $table->string('name', 100)->index(); // Length and index added
            $table->string('distance', 50)->nullable(); // Length defined
            $table->timestamps();
            $table->softDeletes(); // Soft deletes added

            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_properties');
    }
};
