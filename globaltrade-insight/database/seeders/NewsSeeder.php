<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $positiveTitles = [
            'Export growth boosts international trade.',
            'Economic outlook remains stable.',
            'Foreign investment continues to increase.',
            'Trade agreements improve market access.',
        ];

        $neutralTitles = [
            'Government releases latest trade report.',
            'Port activities continue as scheduled.',
            'Economic statistics updated this week.',
            'International trade conference held today.',
        ];

        $negativeTitles = [
            'Shipping delays affect exports.',
            'Economic slowdown impacts trade.',
            'Supply chain disruption reported.',
            'Global market uncertainty increases.',
        ];

        foreach (Country::all() as $country) {

            $type = rand(1, 3);

            if ($type == 1) {
                $title = $positiveTitles[array_rand($positiveTitles)];
                $sentiment = 'Positive';
                $score = 20;
            } elseif ($type == 2) {
                $title = $neutralTitles[array_rand($neutralTitles)];
                $sentiment = 'Neutral';
                $score = 10;
            } else {
                $title = $negativeTitles[array_rand($negativeTitles)];
                $sentiment = 'Negative';
                $score = 0;
            }

            News::create([
                'country_id' => $country->id,
                'title' => $country->name . ': ' . $title,
                'sentiment' => $sentiment,
                'news_score' => $score,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}