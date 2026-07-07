<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exchange_rates', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            $table->string('currency', 10); // Contoh: USD, EUR, IDR, CNY

            $table->decimal('rate', 15, 4); // Nilai kurs

            $table->integer('exchange_score');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};