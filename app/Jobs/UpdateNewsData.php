<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateNewsData implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $apiKey = env('GNEWS_API_KEY');
        $countries = \App\Models\Country::all();

        if ($apiKey) {
            foreach ($countries as $country) {
                try {
                    $response = \Illuminate\Support\Facades\Http::get('https://gnews.io/api/v4/search', [
                        'q' => $country->name . ' economy OR trade OR supply chain',
                        'lang' => 'en',
                        'max' => 2,
                        'apikey' => $apiKey
                    ]);

                    if ($response->successful()) {
                        $articles = $response->json('articles') ?? [];
                        foreach ($articles as $article) {
                            // Basic sentiment logic
                            $sentiment = 'neutral';
                            $titleLower = strtolower($article['title']);
                            if (str_contains($titleLower, 'growth') || str_contains($titleLower, 'boom') || str_contains($titleLower, 'up')) $sentiment = 'positive';
                            if (str_contains($titleLower, 'crisis') || str_contains($titleLower, 'drop') || str_contains($titleLower, 'disruption')) $sentiment = 'negative';

                            \App\Models\News::updateOrCreate(
                                ['url' => $article['url']],
                                [
                                    'country_id' => $country->id,
                                    'title' => $article['title'],
                                    'source' => $article['source']['name'] ?? 'GNews',
                                    'published_at' => date('Y-m-d H:i:s', strtotime($article['publishedAt'])),
                                    'sentiment' => $sentiment,
                                    'news_score' => $sentiment === 'negative' ? rand(60, 100) : ($sentiment === 'positive' ? rand(10, 30) : rand(30, 60))
                                ]
                            );
                        }
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("GNews API Error for {$country->name}: " . $e->getMessage());
                }
            }
        } else {
            // Fallback
            $sentiments = ['positive', 'negative', 'neutral'];
            $titles = [
                'Market sees unexpected growth in ',
                'Supply chain disruptions affect ',
                'New trade agreements signed by ',
                'Economic outlook remains stable for ',
                'Investors show concern over policies in ',
                'Tech sector booms in '
            ];

            foreach ($countries as $country) {
                if (rand(1, 100) <= 30) {
                    $sentiment = $sentiments[array_rand($sentiments)];
                    $titlePrefix = $titles[array_rand($titles)];
                    
                    \App\Models\News::create([
                        'country_id' => $country->id,
                        'title' => $titlePrefix . $country->name,
                        'url' => 'https://example.com/news/' . uniqid(),
                        'source' => 'GlobalTrade Insight',
                        'published_at' => now(),
                        'sentiment' => $sentiment,
                        'news_score' => $sentiment === 'negative' ? rand(60, 100) : ($sentiment === 'positive' ? rand(10, 30) : rand(30, 60))
                    ]);
                }
            }
        }
    }
}
