<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | COUNTRY PROFILE
            |--------------------------------------------------------------------------
            */

            $table->string('name')->nullable();
            $table->string('official_name')->nullable();
            $table->string('code', 10)->nullable(); // ISO2
            $table->string('flag')->nullable();

            /*
            |--------------------------------------------------------------------------
            | GEOGRAPHY
            |--------------------------------------------------------------------------
            */

            $table->string('region')->nullable();
            $table->string('subregion')->nullable();
            $table->string('capital')->nullable();
            $table->text('languages')->nullable();
            $table->decimal('area', 15, 2)->nullable();
            $table->text('timezones')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            /*
            |--------------------------------------------------------------------------
            | CURRENCY
            |--------------------------------------------------------------------------
            */

            $table->string('currency')->nullable();
            $table->string('currency_name')->nullable();
            $table->string('currency_symbol', 10)->nullable();

            /*
            |--------------------------------------------------------------------------
            | ECONOMIC INTELLIGENCE
            |--------------------------------------------------------------------------
            */

            $table->decimal('gdp', 20, 2)->nullable();
            $table->decimal('gdp_per_capita', 20, 2)->nullable();
            $table->decimal('inflation', 8, 2)->nullable();
            $table->decimal('unemployment', 8, 2)->nullable();
            $table->integer('population')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};