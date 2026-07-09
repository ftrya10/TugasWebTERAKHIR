<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExchangeRate;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExchangeRate::insert([

            [
                'country_id' => 1,
                'currency' => 'EUR',
                'rate' => 1.09,
                'exchange_score' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'country_id' => 2,
                'currency' => 'CNY',
                'rate' => 7.25,
                'exchange_score' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'country_id' => 3,
                'currency' => 'IDR',
                'rate' => 16300,
                'exchange_score' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'country_id' => 4,
                'currency' => 'AUD',
                'rate' => 1.52,
                'exchange_score' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}