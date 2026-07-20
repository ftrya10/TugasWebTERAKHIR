@extends('layouts.app')

@section('content')

<h1 class="text-4xl font-bold mb-6">
    Global Country Dashboard
</h1>

{{-- Dropdown Pilih Negara Dinamis --}}
<div class="flex justify-between items-center mb-6">
    <form action="{{ route('dashboard') }}" method="GET" id="countryForm">
        <select name="country" onchange="document.getElementById('countryForm').submit()" class="border rounded-lg px-4 py-2 shadow-sm cursor-pointer bg-white">
            @foreach($countries as $c)
                <option value="{{ $c->id }}" {{ optional($country)->id == $c->id ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
    </form>
</div>

<div class="grid grid-cols-12 gap-6">

    <!-- ================= LEFT ================= -->
    <div class="col-span-6 space-y-6">

        {{-- Grid Card Informasi Dinamis --}}
        <div class="grid grid-cols-2 gap-4">

            @php
                $gdpVal = is_numeric(optional($country)->gdp) ? (float)$country->gdp : 0;
                $popVal = is_numeric(optional($country)->population) ? (float)$country->population : 0;
            @endphp

            <div class="bg-white rounded-xl shadow p-4 h-36">
                <p class="text-gray-500">GDP</p>
                <h2 class="text-3xl font-bold mt-3">
                    @if($gdpVal >= 1e12)
                        ${{ number_format($gdpVal / 1e12, 1) }} Trillion
                    @elseif($gdpVal >= 1e9)
                        ${{ number_format($gdpVal / 1e9, 1) }} Billion
                    @else
                        ${{ number_format($gdpVal) }}
                    @endif
                </h2>
            </div>

            <div class="bg-white rounded-xl shadow p-4 h-36">
                <p class="text-gray-500">Inflation</p>
                <h2 class="text-3xl font-bold mt-3">{{ optional($country)->inflation ?? '0' }}%</h2>
            </div>

            <div class="bg-white rounded-xl shadow p-4 h-36">
                <p class="text-gray-500">Population</p>
                <h2 class="text-3xl font-bold mt-3">
                    @if($popVal >= 1e9)
                        {{ number_format($popVal / 1e9, 1) }} Billion
                    @elseif($popVal >= 1e6)
                        {{ number_format($popVal / 1e6, 0) }} Million
                    @else
                        {{ number_format($popVal) }}
                    @endif
                </h2>
            </div>

            <div class="bg-white rounded-xl shadow p-4 h-36">
                <p class="text-gray-500">Currency</p>
                <h2 class="text-3xl font-bold mt-3">{{ optional($country)->currency ?? '-' }}</h2>
            </div>

            <div class="bg-white rounded-xl shadow p-4 h-36">
                <p class="text-gray-500">Current Weather</p>
                <h2 class="text-2xl font-bold mt-2">{{ optional(optional($country)->weather)->temp ?? 20 }}°C</h2>
                <p class="text-gray-500 mt-2">☁️ {{ optional(optional($country)->weather)->condition ?? 'Cloudy' }}</p>
            </div>

            <div class="bg-white rounded-xl shadow p-4 h-36">
                <p class="text-gray-500">Exchange Rate</p>
                <h2 class="text-2xl font-bold mt-2">
                    1 {{ optional($country)->currency }} = {{ optional(optional($country)->exchangeRate)->rate ?? 1.0 }} USD
                </h2>
            </div>

        </div>

        <!-- LANGKAH 3: GRAFIK VISUALISASI DATA (CHART.JS) -->
        <div class="bg-white rounded-xl shadow p-5">
            <h2 class="text-xl font-bold mb-4">
                📊 Country Risk & Analytics Comparison
            </h2>
            <canvas id="trendChart" height="220"></canvas>
        </div>

    </div>

    <!-- ================= RIGHT ================= -->
    <div class="col-span-6 space-y-4">

        <!-- MAP -->
        <div class="bg-white rounded-xl shadow p-5">
            <h2 class="text-2xl font-bold mb-4">
                🌍 World Trade Map
            </h2>
            <div id="map" class="rounded-lg w-full" style="height:420px;"></div>
        </div>

        <!-- RISK SCORING ENGINE -->
        <div class="bg-white rounded-xl shadow p-5">

            <h2 class="text-xl font-bold mb-5">
                Risk Scoring Engine ({{ optional($country)->name }})
            </h2>

            <div class="grid grid-cols-5 text-center gap-2">

                <div>
                    <p class="text-gray-500 text-sm">Weather</p>
                    <h3 class="text-2xl font-bold">{{ optional(optional($country)->riskScore)->weather_score ?? 0 }}</h3>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Inflation</p>
                    <h3 class="text-2xl font-bold">{{ optional(optional($country)->riskScore)->inflation_score ?? 0 }}</h3>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Exchange</p>
                    <h3 class="text-2xl font-bold">{{ optional(optional($country)->riskScore)->exchange_score ?? 0 }}</h3>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">News</p>
                    <h3 class="text-2xl font-bold">{{ optional(optional($country)->riskScore)->news_score ?? 0 }}</h3>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Total</p>
                    <h3 class="text-2xl font-bold text-red-600">{{ optional(optional($country)->riskScore)->total_score ?? 0 }}</h3>
                </div>

            </div>

            <div class="text-center mt-5">
                @php
                    $status = optional(optional($country)->riskScore)->status ?? 'Low Risk';
                @endphp

                @if($status == 'Low Risk')
                    <span class="bg-green-100 text-green-700 px-6 py-2 rounded-full font-bold">
                        Low Risk
                    </span>
                @elseif($status == 'Medium Risk')
                    <span class="bg-yellow-100 text-yellow-700 px-6 py-2 rounded-full font-bold">
                        Medium Risk
                    </span>
                @else
                    <span class="bg-red-100 text-red-700 px-6 py-2 rounded-full font-bold">
                        High Risk
                    </span>
                @endif
            </div>

        </div>

    </div>

</div>

{{-- Leaflet Map CSS/JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// 1. LEAFLET MAP INITIALIZATION
const map = L.map('map').setView([20,0],2);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
    attribution:'© OpenStreetMap'
}).addTo(map);

L.marker([52.52,13.40]).addTo(map).bindPopup("<b>Germany</b>");
L.marker([-6.20,106.80]).addTo(map).bindPopup("<b>Indonesia</b>");
L.marker([39.90,116.40]).addTo(map).bindPopup("<b>China</b>");
L.marker([-35.28,149.13]).addTo(map).bindPopup("<b>Australia</b>");

// 2. CHART.JS INITIALIZATION (Data Visualization)
const ctx = document.getElementById('trendChart').getContext('2d');
const trendChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Germany', 'China', 'Indonesia', 'Australia'],
        datasets: [
            {
                label: 'Risk Score',
                data: [60, 85, 115, 155],
                backgroundColor: 'rgba(239, 68, 68, 0.7)',
                borderColor: 'rgba(239, 68, 68, 1)',
                borderWidth: 1
            },
            {
                label: 'Inflation Rate (%)',
                data: [2.4, 0.7, 3.2, 2.9],
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

@endsection