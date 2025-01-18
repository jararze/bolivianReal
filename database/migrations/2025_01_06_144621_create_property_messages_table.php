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
        Schema::create('property_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index(); // Index added
            $table->unsignedBigInteger('property_id')->nullable()->index(); // Index added
            $table->unsignedBigInteger('agent_id')->nullable()->index(); // Index added
            $table->string('name', 100)->nullable(); // Length defined
            $table->string('email', 150)->nullable(); // Length defined
            $table->string('phone', 20)->nullable(); // Length defined
            $table->text('message')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Soft deletes added

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_messages');
    }
};
