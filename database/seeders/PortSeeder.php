<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Port;
use App\Models\Country;
use Illuminate\Support\Facades\Http;

class PortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = Country::all();
        if ($countries->isEmpty()) {
            return;
        }

        // Example: Generate dummy port data since World Port Index API may require specific endpoints
        // Here we simulate fetching 500 ports globally and attaching them to random countries
        
        $statuses = ['active', 'inactive', 'congested'];

        for ($i = 0; $i < 500; $i++) {
            Port::create([
                'country_id' => $countries->random()->id,
                'name' => 'Port of ' . fake()->city(),
                // Generate random global coordinates
                'latitude' => fake()->latitude(-60, 70),
                'longitude' => fake()->longitude(-180, 180),
                'status' => $statuses[array_rand($statuses)],
            ]);
        }

        // Alternative if using an actual API:
        /*
        $response = Http::get('https://some-port-api.com/ports');
        if ($response->successful()) {
            foreach($response->json() as $portData) {
                Port::create([...]);
            }
        }
        */
    }
}