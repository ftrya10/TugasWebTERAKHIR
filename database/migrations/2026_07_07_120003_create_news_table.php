<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('content')->nullable();
            $table->string('source')->nullable();

            $table->enum('sentiment', [
                'Positive',
                'Neutral',
                'Negative'
            ]);

            $table->integer('news_score');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};