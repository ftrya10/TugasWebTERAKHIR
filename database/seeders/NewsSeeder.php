<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        News::insert([

            [
                'country_id' => 1,
                'title' => 'Germany Export Growth',
                'sentiment' => 'Positive',
                'news_score' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'country_id' => 2,
                'title' => 'China Trade Policy',
                'sentiment' => 'Neutral',
                'news_score' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'country_id' => 3,
                'title' => 'Indonesia Economic Update',
                'sentiment' => 'Negative',
                'news_score' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'country_id' => 4,
                'title' => 'Australia Export Market',
                'sentiment' => 'Positive',
                'news_score' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}