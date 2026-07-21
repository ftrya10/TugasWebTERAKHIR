@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">Global Country Dashboard</h1>

@if($countries && $countries->count())

    {{-- Dropdown Pilihan Negara --}}
    <form method="GET" action="{{ route('dashboard') }}" id="countryForm">
        <select name="country" class="border rounded-lg px-4 py-2 bg-white shadow-sm cursor-pointer" onchange="this.form.submit()">
            @foreach($countries as $item)
                <option value="{{ $item->id }}" {{ optional($country)->id == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}
                </option>
            @endforeach
        </select>
    </form>

    <div id="map-config" 
         data-lat="{{ $country->latitude ?? -6.2088 }}" 
         data-lng="{{ $country->longitude ?? 106.8456 }}" 
         data-name="{{ $country->name ?? 'Country' }}">
    </div>

    <div class="grid grid-cols-12 gap-6 mt-6">
        
        {{-- Sisi Kiri (Data Ekonomi) --}}
        <div class="col-span-12 lg:col-span-6 space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white shadow rounded-xl p-5">
                    <h2 class="font-semibold text-gray-500">GDP</h2>
                    <p class="text-2xl font-bold mt-2">{{ $country->gdp ? '$' . number_format((float)$country->gdp) : '-' }}</p>
                </div>
                <div class="bg-white shadow rounded-xl p-5">
                    <h2 class="font-semibold text-gray-500">Inflation</h2>
                    <p class="text-2xl font-bold mt-2">{{ $country->inflation ?? '0' }}%</p>
                </div>
                <div class="bg-white shadow rounded-xl p-5">
                    <h2 class="font-semibold text-gray-500">Currency</h2>
                    <p class="text-2xl font-bold mt-2">{{ $country->currency ?? '-' }}</p>
                </div>
                <div class="bg-white shadow rounded-xl p-5">
                    <h2 class="font-semibold text-gray-500">Weather</h2>
                    <p class="text-2xl font-bold mt-2">{{ $country->weather->temperature ?? '-' }}°C</p>
                </div>
            </div>
        </div>

        {{-- Sisi Kanan (Peta) --}}
        <div class="col-span-12 lg:col-span-6">
            <div class="bg-white shadow rounded-xl p-5">
                <h2 class="text-xl font-bold mb-4">🌍 Interactive Map</h2>
                <div id="map" class="rounded-lg w-full" style="height: 280px;"></div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const config = document.getElementById('map-config');
            const lat = parseFloat(config.dataset.lat) || -6.2088;
            const lng = parseFloat(config.dataset.lng) || 106.8456;
            const name = config.dataset.name || 'Country';

            // Bersihkan instance peta sebelumnya jika ada (untuk mencegah error saat ganti negara)
            const container = L.DomUtil.get('map');
            if(container != null){ container._leaflet_id = null; }

            const map = L.map('map').setView([lat, lng], 4);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup('<b>' + name + '</b>')
                .openPopup();
        });
    </script>

@else
    <div class="bg-yellow-100 border border-yellow-400 p-5 rounded-xl text-yellow-800">
        Belum ada data negara yang tersedia.
    </div>
@endif

@endsection