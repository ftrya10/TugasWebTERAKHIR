<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\ExchangeRate;
use Illuminate\Database\Seeder;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Country::all() as $country) {

            ExchangeRate::create([
                'country_id' => $country->id,
                'currency' => $country->currency ?? 'USD',
                'rate' => rand(50, 20000) / 100,
                'exchange_score' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }
}