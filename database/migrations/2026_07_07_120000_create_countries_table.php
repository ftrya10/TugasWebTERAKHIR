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

            $table->string('name');
            $table->string('code', 3);
            $table->string('flag')->nullable();
            $table->string('region')->nullable();

            $table->string('gdp')->nullable();
            $table->decimal('inflation', 5, 2)->nullable();
            $table->string('population')->nullable();
            $table->string('currency')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};