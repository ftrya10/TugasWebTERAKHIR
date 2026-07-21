<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Country;
use App\Models\MarketTrend;

class GlobalDashboard extends Component
{
    public $selectedCountryId = null;
    public $countryData = null;
    
    // Day.js will be handled on the frontend for local UTC time
    
    public function mount()
    {
        $this->selectedCountryId = Country::first()->id ?? null;
        $this->loadCountryData();
    }

    public function loadCountryData()
    {
        if ($this->selectedCountryId) {
            $this->countryData = Country::with(['marketTrends' => function($query) {
                $query->latest('recorded_at')->take(1);
            }])->find($this->selectedCountryId);
        }
    }

    public function selectCountry($id)
    {
        $this->selectedCountryId = $id;
        $this->loadCountryData();
    }

    public function render()
    {
        $countries = Country::all();
        return view('livewire.dashboard.global-dashboard', [
            'countries' => $countries
        ])->layout('layouts.app'); // Ensure you have an app layout with Deep Dark Tailwind
    }
}
