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
        Schema::create('market_trends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->decimal('currency_rate', 15, 4)->nullable(); // e.g. vs USD
            $table->decimal('inflation_rate', 5, 2)->nullable();
            $table->decimal('risk_score', 5, 2)->nullable(); // 0 - 100
            $table->string('weather_condition')->nullable(); // e.g. Clear, Storm
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_trends');
    }
};
