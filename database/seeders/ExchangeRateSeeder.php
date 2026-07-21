<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\ExchangeRate;
use Illuminate\Database\Seeder;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Menggunakan kurs realistis terhadap USD (per Juli 2026 approx).
     */
    public function run(): void
    {
        // Kurs realistis: berapa unit mata uang lokal per 1 USD
        $realisticRates = [
            'IDR' => 15890.00,   // Indonesian Rupiah
            'CNY' => 7.25,       // Chinese Yuan
            'EUR' => 0.92,       // Euro
            'AUD' => 1.53,       // Australian Dollar
            'USD' => 1.00,       // US Dollar
            'JPY' => 157.50,     // Japanese Yen
            'SGD' => 1.35,       // Singapore Dollar
            'GBP' => 0.79,       // British Pound
            'INR' => 83.50,      // Indian Rupee
            'MYR' => 4.72,       // Malaysian Ringgit
        ];

        foreach (Country::all() as $country) {
            $currencyCode = $country->currency ?? 'USD';
            $rate = $realisticRates[$currencyCode] ?? rand(50, 20000) / 100;

            // Exchange score: higher volatility = higher score
            $exchangeScore = match(true) {
                $rate > 1000  => rand(6, 9),
                $rate > 100   => rand(4, 7),
                $rate > 10    => rand(3, 5),
                $rate > 1     => rand(2, 4),
                default       => rand(1, 3),
            };

            ExchangeRate::updateOrCreate(
                ['country_id' => $country->id],
                [
                    'currency'       => $currencyCode,
                    'rate'           => $rate,
                    'exchange_score' => $exchangeScore,
                    'updated_at'     => now(),
                ]
            );
        }
    }
}