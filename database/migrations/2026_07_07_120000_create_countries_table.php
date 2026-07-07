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
            $table->string('flag')->nullable();      // URL atau nama file bendera
            $table->string('gdp');
            $table->decimal('inflation', 5, 2);
            $table->string('population');
            $table->string('currency');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};