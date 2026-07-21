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
