<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure Admin user exists with admin role
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Admin GlobalTrade',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        try {
            \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
            \App\Models\News::query()->delete();
            \App\Models\Article::query()->delete();
            \App\Models\RiskScore::query()->delete();
            \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        } catch (\Throwable $e) {
            // Ignore if tables do not exist yet
        }

        $this->call([
            CountrySeeder::class,
            WeatherSeeder::class,
            ExchangeRateSeeder::class,
            NewsSeeder::class,
            RiskScoreSeeder::class,
            PortSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
