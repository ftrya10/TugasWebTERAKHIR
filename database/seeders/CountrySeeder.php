<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::insert([

            [
                'name' => 'Germany',
                'flag' => null,
                'gdp' => '$4.7 Trillion',
                'inflation' => 2.4,
                'population' => '84 Million',
                'currency' => 'EUR',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'China',
                'flag' => null,
                'gdp' => '$18 Trillion',
                'inflation' => 0.7,
                'population' => '1.4 Billion',
                'currency' => 'CNY',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Indonesia',
                'flag' => null,
                'gdp' => '$1.5 Trillion',
                'inflation' => 3.2,
                'population' => '280 Million',
                'currency' => 'IDR',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Australia',
                'flag' => null,
                'gdp' => '$1.8 Trillion',
                'inflation' => 2.9,
                'population' => '27 Million',
                'currency' => 'AUD',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}