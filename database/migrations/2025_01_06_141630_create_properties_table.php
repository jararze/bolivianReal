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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('slug')->index();
            $table->string('code')->index();
            $table->boolean('is_project'); // Cambiado de enum a boolean
            $table->unsignedBigInteger('service_type_id')->nullable()->index();
            $table->unsignedBigInteger('project_id')->nullable()->index();
            $table->string('project_status')->nullable();
            $table->date('delivery')->nullable();
            $table->integer('units')->nullable();
            $table->date('construction_Date')->nullable();
            $table->decimal('lowest_price', 15, 2)->index();
            $table->decimal('max_price', 15, 2)->nullable()->index();
            $table->enum('currency', ['Bs', '$us'])->nullable(); // Manteniendo enum
            $table->string('thumbnail')->nullable();
            $table->text('short_description');
            $table->text('long_description');
            $table->tinyInteger('bedrooms')->nullable(); // Cambiado a tinyInteger
            $table->tinyInteger('bedrooms_max')->nullable();
            $table->tinyInteger('bathrooms')->nullable();
            $table->tinyInteger('bathrooms_max')->nullable();
            $table->tinyInteger('garage')->nullable();
            $table->tinyInteger('garage_max')->nullable();
            $table->decimal('garage_size', 8, 2)->nullable(); // Mayor precisión
            $table->decimal('garage_size_max', 8, 2)->nullable();
            $table->decimal('size', 10, 2)->nullable();
            $table->decimal('size_max', 10, 2)->nullable();
            $table->string('video')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable()->index();
            $table->string('country')->nullable();
            $table->string('neighborhood')->nullable();
            $table->decimal('latitude', 10, 8)->nullable(); // Precisión para coordenadas
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('featured')->default(0); // Cambiado a boolean
            $table->boolean('hot')->default(0); // Cambiado a boolean
            $table->unsignedBigInteger('propertytype_id')->index();
            $table->string('amenities_id')->nullable();
            $table->unsignedBigInteger('agent_id')->index();
            $table->unsignedBigInteger('created_by');
            $table->boolean('status')->default(0); // Cambiado a boolean
            $table->tinyInteger('status_for_what')->default(0); // Optimizado a tinyInteger
            $table->boolean('chosen_currency')->default(1); // Cambiado a boolean
            $table->integer('sold_units')->default(0);
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('set null');
            $table->foreign('propertytype_id')->references('id')->on('property_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
