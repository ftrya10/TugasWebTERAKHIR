<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_scores', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            // Nilai setiap indikator
            $table->integer('weather_score')->default(0);
            $table->integer('inflation_score')->default(0);
            $table->integer('exchange_score')->default(0);
            $table->integer('news_score')->default(0);

            // Total nilai
            $table->integer('total_score')->default(0);

            // Status risiko
            $table->enum('status', [
                'Low Risk',
                'Medium Risk',
                'High Risk'
            ])->default('Low Risk');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_scores');
    }
};