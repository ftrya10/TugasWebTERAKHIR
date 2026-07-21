<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            $table->decimal('temperature', 6, 2)
                ->nullable();

            $table->decimal('humidity', 6, 2)
                ->nullable();

            $table->decimal('rain', 8, 2)
                ->nullable();

            $table->decimal('wind_speed', 8, 2)
                ->nullable();

            $table->string('condition')
                ->nullable();

            $table->unsignedTinyInteger('weather_score')
                ->default(0);

            $table->timestamp('measured_at')
                ->nullable();

            $table->timestamps();

            $table->unique('country_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weather');
    }
};