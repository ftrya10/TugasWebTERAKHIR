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

            $table->string('currency', 10);

            // Nilai kurs terhadap base currency
            $table->decimal('rate', 15, 6)
                ->nullable();

            // Nilai kurs sebelumnya
            $table->decimal('previous_rate', 15, 6)
                ->nullable();

            // Persentase perubahan kurs
            $table->decimal('change_percent', 8, 4)
                ->nullable();

            // Skor risiko nilai tukar 0 - 100
            $table->unsignedTinyInteger('exchange_score')
                ->default(0);

            // Waktu data kurs diperbarui
            $table->timestamp('recorded_at')
                ->nullable();

            $table->timestamps();

            // Satu negara memiliki satu data kurs terbaru
            $table->unique('country_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};