<?php

namespace App\Livewire\Analytics;

use Livewire\Component;
use App\Models\Country;

class CountryCompare extends Component
{
    public $country1Id;
    public $country2Id;

    public function mount()
    {
        $countries = Country::take(2)->get();
        if ($countries->count() >= 2) {
            $this->country1Id = $countries[0]->id;
            $this->country2Id = $countries[1]->id;
        }
    }

    public function getChartDataProperty()
    {
        $c1 = Country::with('marketTrends')->find($this->country1Id);
        $c2 = Country::with('marketTrends')->find($this->country2Id);

        if (!$c1 || !$c2) return null;

        $trend1 = $c1->marketTrends->first();
        $trend2 = $c2->marketTrends->first();

        return [
            'series' => [
                [
                    'name' => $c1->name,
                    'data' => [
                        (float) ($trend1->inflation_rate ?? 0),
                        (float) ($trend1->risk_score ?? 0),
                        (float) ($trend1->currency_rate ?? 0), // normalized if necessary
                    ]
                ],
                [
                    'name' => $c2->name,
                    'data' => [
                        (float) ($trend2->inflation_rate ?? 0),
                        (float) ($trend2->risk_score ?? 0),
                        (float) ($trend2->currency_rate ?? 0),
                    ]
                ]
            ],
            'categories' => ['Inflation Rate (%)', 'Risk Score', 'Currency Rate']
        ];
    }

    public function render()
    {
        return view('livewire.analytics.country-compare', [
            'countries' => Country::all(),
            'chartData' => $this->chartData
        ]);
    }
}
