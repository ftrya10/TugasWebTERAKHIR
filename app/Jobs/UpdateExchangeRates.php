<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateExchangeRates implements ShouldQueue
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
        $countries = \App\Models\Country::with('exchangeRate', 'riskScore')->get();

        foreach ($countries as $country) {
            if ($country->exchangeRate) {
                // Simulate market fluctuation: -0.5% to +0.5%
                $fluctuation = (rand(-50, 50) / 10000) * $country->exchangeRate->rate;
                $newRate = $country->exchangeRate->rate + $fluctuation;
                
                $country->exchangeRate->update([
                    'rate' => round($newRate, 4)
                ]);

                // Also trigger risk recalculation in a real app, 
                // but for now we just want the UI to update.
            }
        }
    }
}
