<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestApiConnection extends Command
{
    protected $signature = 'api:test';

    protected $description = 'Test all API connections';

    public function handle()
    {
        $this->info("Testing API...\n");


        // 1. Open Meteo
        try {
            $response = Http::get(
                'https://api.open-meteo.com/v1/forecast?latitude=5.55&longitude=95.32&current_weather=true'
            );

            $this->line(
                "Open-Meteo: " . 
                ($response->successful() ? "CONNECTED ✅" : "FAILED ❌")
            );

        } catch (\Exception $e) {
            $this->line("Open-Meteo: FAILED ❌");
        }



        // 2. World Bank
        try {
            $response = Http::get(
                'https://api.worldbank.org/v2/country/IDN/indicator/NY.GDP.MKTP.CD?format=json'
            );

            $this->line(
                "World Bank: " .
                ($response->successful() ? "CONNECTED ✅" : "FAILED ❌")
            );

        } catch (\Exception $e) {
            $this->line("World Bank: FAILED ❌");
        }



        // 3. REST Countries
        try {
            $response = Http::get(
                'https://restcountries.com/v3.1/all'
            );

            $this->line(
                "REST Countries: " .
                ($response->successful() ? "CONNECTED ✅" : "FAILED ❌")
            );

        } catch (\Exception $e) {
            $this->line("REST Countries: FAILED ❌");
        }



        // 4. ExchangeRate API
        try {

            $response = Http::get(
                'https://open.er-api.com/v6/latest/USD'
            );

            $this->line(
                "ExchangeRate: " .
                ($response->successful() ? "CONNECTED ✅" : "FAILED ❌")
            );

        } catch (\Exception $e) {
            $this->line("ExchangeRate: FAILED ❌");
        }



        // 5. World Port Index
        try {

            $response = Http::get(
                'https://msi.nga.mil/api/publications/download?key=166'
            );

            $this->line(
                "World Port Index: " .
                ($response->successful() ? "CONNECTED ✅" : "FAILED ❌")
            );

        } catch (\Exception $e) {
            $this->line("World Port Index: FAILED ❌");
        }



        $this->info("\nFinished testing API.");
    }
}