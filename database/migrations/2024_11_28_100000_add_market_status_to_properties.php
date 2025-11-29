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
            // Campos para gestión de propiedades fuera de mercado
            $table->enum('market_status', ['active', 'off_market'])
                ->default('active')
                ->after('status')
                ->index();
            
            $table->enum('off_market_reason', [
                'sold', 
                'rented', 
                'anticretico', 
                'owner_decision', 
                'other'
            ])->nullable()->after('market_status');
            
            $table->text('off_market_notes')->nullable()->after('off_market_reason');
            
            $table->datetime('off_market_date')->nullable()->after('off_market_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'market_status',
                'off_market_reason',
                'off_market_notes',
                'off_market_date',
            ]);
        });
    }
};
