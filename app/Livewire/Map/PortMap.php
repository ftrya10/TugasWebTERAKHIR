<?php

namespace App\Livewire\Map;

use Livewire\Component;
use App\Models\Port;

class PortMap extends Component
{
    public $ports = [];

    public function mount()
    {
        // Load initial ports
        $this->loadPorts();
    }

    public function loadPorts()
    {
        // Fetch ports with minimal data to keep payload small for Leaflet MarkerCluster
        $this->ports = Port::select('id', 'name', 'latitude', 'longitude', 'status')->get()->toArray();
    }

    // Polling logic: fetch updates every 5 minutes (300 seconds)
    // The front-end blade will use wire:poll.300s="loadPorts"
    
    public function render()
    {
        return view('livewire.map.port-map');
    }
}
