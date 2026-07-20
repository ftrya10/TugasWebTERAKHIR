<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama terlebih dahulu agar fresh saat di-seed ulang
        News::truncate();

        News::insert([
            [
                'country_id' => 1,
                // Mengandung kata 'growth' & 'stable' (Positif)
                'title' => 'Germany Export Growth reported stable amid European trade expansion.',
                'sentiment' => 'Positive',
                'news_score' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_id' => 2,
                // Berita umum (Netral)
                'title' => 'China Trade Policy announcement regarding global port regulations.',
                'sentiment' => 'Neutral',
                'news_score' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_id' => 3,
                // Mengandung kata 'crisis' & 'delay' (Negatif)
                'title' => 'Indonesia Economic Update: Shipping crisis causes massive logistics delay.',
                'sentiment' => 'Negative',
                'news_score' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_id' => 4,
                // Mengandung kata 'profit' & 'improve' (Positif)
                'title' => 'Australia Export Market improves profit margins for maritime shipping.',
                'sentiment' => 'Positive',
                'news_score' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}