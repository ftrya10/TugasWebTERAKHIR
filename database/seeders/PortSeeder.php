<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Port;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        Port::insert([
            [
                'country_id' => 3,
                'name' => 'Port of Tanjung Priok',
                'city' => 'Jakarta',
                'latitude' => '-6.1040000',
                'longitude' => '106.8850000',
                'status' => 'Operational',
                'description' => 'Pelabuhan utama perdagangan Indonesia',
            ],
            [
                'country_id' => 2,
                'name' => 'Port of Shanghai',
                'city' => 'Shanghai',
                'latitude' => '31.2300000',
                'longitude' => '121.4900000',
                'status' => 'Operational',
                'description' => 'Pelabuhan perdagangan terbesar China',
            ],
            [
                'country_id' => 1,
                'name' => 'Port of Hamburg',
                'city' => 'Hamburg',
                'latitude' => '53.5400000',
                'longitude' => '9.9800000',
                'status' => 'Operational',
                'description' => 'Pelabuhan utama Jerman',
            ],
            [
                'country_id' => 4,
                'name' => 'Port of Melbourne',
                'city' => 'Melbourne',
                'latitude' => '-37.8400000',
                'longitude' => '144.9200000',
                'status' => 'Operational',
                'description' => 'Pelabuhan perdagangan Australia',
            ],
        ]);
    }
}