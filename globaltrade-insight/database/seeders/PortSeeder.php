<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Port;
use Illuminate\Database\Seeder;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        $ports = [
            [
                'code' => 'ID',
                'name' => 'Port of Tanjung Priok',
                'city' => 'Jakarta',
                'latitude' => -6.1040000,
                'longitude' => 106.8850000,
                'status' => 'Operational',
                'description' => 'Pelabuhan utama perdagangan Indonesia',
            ],
            [
                'code' => 'CN',
                'name' => 'Port of Shanghai',
                'city' => 'Shanghai',
                'latitude' => 31.2300000,
                'longitude' => 121.4900000,
                'status' => 'Operational',
                'description' => 'Pelabuhan perdagangan terbesar China',
            ],
            [
                'code' => 'DE',
                'name' => 'Port of Hamburg',
                'city' => 'Hamburg',
                'latitude' => 53.5400000,
                'longitude' => 9.9800000,
                'status' => 'Operational',
                'description' => 'Pelabuhan utama Jerman',
            ],
            [
                'code' => 'AU',
                'name' => 'Port of Melbourne',
                'city' => 'Melbourne',
                'latitude' => -37.8400000,
                'longitude' => 144.9200000,
                'status' => 'Operational',
                'description' => 'Pelabuhan perdagangan Australia',
            ],
        ];

        foreach ($ports as $port) {

            $country = Country::where('code', $port['code'])->first();

            if ($country) {
                Port::create([
                    'country_id' => $country->id,
                    'name' => $port['name'],
                    'city' => $port['city'],
                    'latitude' => $port['latitude'],
                    'longitude' => $port['longitude'],
                    'status' => $port['status'],
                    'description' => $port['description'],
                ]);
            }
        }
    }
}