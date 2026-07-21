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

            /*
            |--------------------------------------------------------------------------
            | RELASI COUNTRY
            |--------------------------------------------------------------------------
            */

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete()
                ->unique();


            /*
            |--------------------------------------------------------------------------
            | RISK COMPONENTS
            |--------------------------------------------------------------------------
            |
            | Semua skor menggunakan skala 0 - 100
            |
            */

            $table->decimal('weather_score', 5, 2)
                ->default(0);

            $table->decimal('inflation_score', 5, 2)
                ->default(0);

            $table->decimal('exchange_score', 5, 2)
                ->default(0);

            $table->decimal('news_score', 5, 2)
                ->default(0);

            $table->decimal('port_score', 5, 2)
                ->default(0);


            /*
            |--------------------------------------------------------------------------
            | FINAL RISK SCORE
            |--------------------------------------------------------------------------
            */

            $table->decimal('total_score', 5, 2)
                ->default(0);


            /*
            |--------------------------------------------------------------------------
            | RISK STATUS
            |--------------------------------------------------------------------------
            |
            | Status disimpan dalam format lowercase agar konsisten
            | dengan RiskController dan Risk API.
            |
            */

            $table->enum('status', [
                'low',
                'medium',
                'high',
                'critical',
            ])
            ->default('low');


            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_scores');
    }
};