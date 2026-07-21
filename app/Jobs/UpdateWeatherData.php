<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateWeatherData implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $countries = \App\Models\Country::with('weather')->get();
        $conditions = ['Clear', 'Clouds', 'Rain', 'Thunderstorm', 'Snow', 'Drizzle'];

        foreach ($countries as $country) {
            if ($country->weather) {
                // Simulate weather changes
                $tempFluctuation = rand(-2, 2);
                $newTemp = max(-10, min(45, $country->weather->temperature + $tempFluctuation));
                $newCondition = $conditions[array_rand($conditions)];
                
                $country->weather->update([
                    'temperature' => $newTemp,
                    'condition' => $newCondition,
                ]);
            }
        }
    }
}
