<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Port;
use App\Models\Country;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        $countries = Country::all();
        if ($countries->isEmpty()) {
            return;
        }

        $statuses = ['active', 'inactive', 'congested'];

        // Static realistic port data for the 10 countries
        $ports = [
            // Indonesia
            ['name' => 'Port of Tanjung Priok', 'latitude' => -6.1045, 'longitude' => 106.8762, 'country' => 'Indonesia'],
            ['name' => 'Port of Tanjung Perak', 'latitude' => -7.2018, 'longitude' => 112.7317, 'country' => 'Indonesia'],
            ['name' => 'Port of Belawan', 'latitude' => 3.7833, 'longitude' => 98.6833, 'country' => 'Indonesia'],
            ['name' => 'Port of Makassar', 'latitude' => -5.1354, 'longitude' => 119.4139, 'country' => 'Indonesia'],
            ['name' => 'Port of Balikpapan', 'latitude' => -1.2675, 'longitude' => 116.8289, 'country' => 'Indonesia'],
            ['name' => 'Port of Semarang', 'latitude' => -6.9660, 'longitude' => 110.4214, 'country' => 'Indonesia'],
            ['name' => 'Port of Pontianak', 'latitude' => -0.0273, 'longitude' => 109.3425, 'country' => 'Indonesia'],
            ['name' => 'Port of Ambon', 'latitude' => -3.6944, 'longitude' => 128.1814, 'country' => 'Indonesia'],
            // China
            ['name' => 'Port of Shanghai', 'latitude' => 31.2304, 'longitude' => 121.4737, 'country' => 'China'],
            ['name' => 'Port of Shenzhen', 'latitude' => 22.5431, 'longitude' => 114.0579, 'country' => 'China'],
            ['name' => 'Port of Ningbo', 'latitude' => 29.8683, 'longitude' => 121.5440, 'country' => 'China'],
            ['name' => 'Port of Guangzhou', 'latitude' => 23.1291, 'longitude' => 113.2644, 'country' => 'China'],
            ['name' => 'Port of Tianjin', 'latitude' => 39.1422, 'longitude' => 117.1767, 'country' => 'China'],
            ['name' => 'Port of Qingdao', 'latitude' => 36.0671, 'longitude' => 120.3826, 'country' => 'China'],
            ['name' => 'Port of Dalian', 'latitude' => 38.9140, 'longitude' => 121.6147, 'country' => 'China'],
            ['name' => 'Port of Xiamen', 'latitude' => 24.4798, 'longitude' => 118.0894, 'country' => 'China'],
            // USA
            ['name' => 'Port of Los Angeles', 'latitude' => 33.7300, 'longitude' => -118.2564, 'country' => 'United States'],
            ['name' => 'Port of New York', 'latitude' => 40.6643, 'longitude' => -74.0060, 'country' => 'United States'],
            ['name' => 'Port of Houston', 'latitude' => 29.7555, 'longitude' => -95.2205, 'country' => 'United States'],
            ['name' => 'Port of Savannah', 'latitude' => 32.0809, 'longitude' => -81.0912, 'country' => 'United States'],
            ['name' => 'Port of Long Beach', 'latitude' => 33.7542, 'longitude' => -118.2165, 'country' => 'United States'],
            ['name' => 'Port of Seattle', 'latitude' => 47.6062, 'longitude' => -122.3321, 'country' => 'United States'],
            // Germany
            ['name' => 'Port of Hamburg', 'latitude' => 53.5753, 'longitude' => 9.9218, 'country' => 'Germany'],
            ['name' => 'Port of Bremen', 'latitude' => 53.0793, 'longitude' => 8.8017, 'country' => 'Germany'],
            ['name' => 'Port of Rostock', 'latitude' => 54.0887, 'longitude' => 12.1405, 'country' => 'Germany'],
            // Japan
            ['name' => 'Port of Tokyo', 'latitude' => 35.6762, 'longitude' => 139.6503, 'country' => 'Japan'],
            ['name' => 'Port of Yokohama', 'latitude' => 35.4437, 'longitude' => 139.6380, 'country' => 'Japan'],
            ['name' => 'Port of Osaka', 'latitude' => 34.6937, 'longitude' => 135.5023, 'country' => 'Japan'],
            ['name' => 'Port of Nagoya', 'latitude' => 35.1815, 'longitude' => 136.9066, 'country' => 'Japan'],
            ['name' => 'Port of Kobe', 'latitude' => 34.6901, 'longitude' => 135.1956, 'country' => 'Japan'],
            // Australia
            ['name' => 'Port of Melbourne', 'latitude' => -37.8136, 'longitude' => 144.9631, 'country' => 'Australia'],
            ['name' => 'Port of Sydney', 'latitude' => -33.8688, 'longitude' => 151.2093, 'country' => 'Australia'],
            ['name' => 'Port of Brisbane', 'latitude' => -27.4698, 'longitude' => 153.0251, 'country' => 'Australia'],
            ['name' => 'Port of Fremantle', 'latitude' => -32.0569, 'longitude' => 115.7439, 'country' => 'Australia'],
            // India
            ['name' => 'Port of Mumbai', 'latitude' => 18.9750, 'longitude' => 72.8258, 'country' => 'India'],
            ['name' => 'Port of Jawaharlal Nehru', 'latitude' => 18.9496, 'longitude' => 72.9450, 'country' => 'India'],
            ['name' => 'Port of Chennai', 'latitude' => 13.0827, 'longitude' => 80.2707, 'country' => 'India'],
            ['name' => 'Port of Kolkata', 'latitude' => 22.5726, 'longitude' => 88.3639, 'country' => 'India'],
            ['name' => 'Port of Visakhapatnam', 'latitude' => 17.6868, 'longitude' => 83.2185, 'country' => 'India'],
            // Brazil
            ['name' => 'Port of Santos', 'latitude' => -23.9535, 'longitude' => -46.3333, 'country' => 'Brazil'],
            ['name' => 'Port of Paranagua', 'latitude' => -25.5200, 'longitude' => -48.5100, 'country' => 'Brazil'],
            ['name' => 'Port of Rio de Janeiro', 'latitude' => -22.9068, 'longitude' => -43.1729, 'country' => 'Brazil'],
            ['name' => 'Port of Itajai', 'latitude' => -26.9063, 'longitude' => -48.6616, 'country' => 'Brazil'],
            // Saudi Arabia
            ['name' => 'Port of Jeddah', 'latitude' => 21.5433, 'longitude' => 39.1728, 'country' => 'Saudi Arabia'],
            ['name' => 'Port of Dammam', 'latitude' => 26.4367, 'longitude' => 50.1033, 'country' => 'Saudi Arabia'],
            ['name' => 'Port of Jubail', 'latitude' => 27.0174, 'longitude' => 49.6579, 'country' => 'Saudi Arabia'],
            // South Korea
            ['name' => 'Port of Busan', 'latitude' => 35.1796, 'longitude' => 129.0756, 'country' => 'South Korea'],
            ['name' => 'Port of Incheon', 'latitude' => 37.4563, 'longitude' => 126.7052, 'country' => 'South Korea'],
            ['name' => 'Port of Ulsan', 'latitude' => 35.5384, 'longitude' => 129.3114, 'country' => 'South Korea'],
            ['name' => 'Port of Gwangyang', 'latitude' => 34.9333, 'longitude' => 127.7000, 'country' => 'South Korea'],
        ];

        foreach ($ports as $portData) {
            $country = $countries->firstWhere('name', $portData['country']);
            if ($country) {
                Port::firstOrCreate(
                    ['name' => $portData['name']],
                    [
                        'country_id' => $country->id,
                        'latitude'   => $portData['latitude'],
                        'longitude'  => $portData['longitude'],
                        'status'     => $statuses[array_rand($statuses)],
                    ]
                );
            }
        }
    }
}