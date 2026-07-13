@extends('layouts.app')

@section('content')

<h1 class="text-4xl font-bold mb-6">
    Global Country Dashboard
</h1>

<div class="flex justify-between items-center mb-6">
    <select class="border rounded-lg px-4 py-2 shadow-sm">
        <option>Germany</option>
        <option>China</option>
        <option>Indonesia</option>
        <option>Australia</option>
    </select>
</div>

<div class="grid grid-cols-12 gap-6">

    <!-- ================= LEFT ================= -->
    <div class="col-span-6">

        <div class="grid grid-cols-2 gap-4">

            <div class="bg-white rounded-xl shadow p-4 h-36">
                <p class="text-gray-500">GDP</p>
                <h2 class="text-3xl font-bold mt-3">$4.7 Trillion</h2>
            </div>

            <div class="bg-white rounded-xl shadow p-4 h-36">
                <p class="text-gray-500">Inflation</p>
                <h2 class="text-3xl font-bold mt-3">2.40%</h2>
            </div>

            <div class="bg-white rounded-xl shadow p-4 h-36">
                <p class="text-gray-500">Population</p>
                <h2 class="text-3xl font-bold mt-3">84 Million</h2>
            </div>

            <div class="bg-white rounded-xl shadow p-4 h-36">
                <p class="text-gray-500">Currency</p>
                <h2 class="text-3xl font-bold mt-3">EUR</h2>
            </div>

            <div class="bg-white rounded-xl shadow p-4 h-36">
                <p class="text-gray-500">Current Weather</p>
                <h2 class="text-2xl font-bold mt-2">18°C</h2>
                <p class="text-gray-500 mt-2">☁️ Cloudy</p>
            </div>

            <div class="bg-white rounded-xl shadow p-4 h-36">
                <p class="text-gray-500">Exchange Rate</p>
                <h2 class="text-2xl font-bold mt-2">
                    1 EUR = 1.09 USD
                </h2>
            </div>

        </div>

    </div>

    <!-- ================= RIGHT ================= -->
    <div class="col-span-6 space-y-4">

        <!-- MAP -->
        <div class="bg-white rounded-xl shadow p-5">

            <h2 class="text-2xl font-bold mb-4">
                🌍 World Trade Map
            </h2>

            <div id="map" class="rounded-lg w-full" style="height:500px;"></div>

        </div>

        <!-- RISK -->
        <div class="bg-white rounded-xl shadow p-5">

            <h2 class="text-xl font-bold mb-5">
                Risk Scoring Engine
            </h2>

            <div class="grid grid-cols-5 text-center gap-2">

                <div>
                    <p class="text-gray-500 text-sm">Weather</p>
                    <h3 class="text-2xl font-bold">5</h3>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Inflation</p>
                    <h3 class="text-2xl font-bold">3</h3>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Exchange</p>
                    <h3 class="text-2xl font-bold">4</h3>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">News</p>
                    <h3 class="text-2xl font-bold">2</h3>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Total</p>
                    <h3 class="text-2xl font-bold text-red-600">14</h3>
                </div>

            </div>

            <div class="text-center mt-5">

                <span class="bg-green-100 text-green-700 px-6 py-2 rounded-full font-bold">
                    Low Risk
                </span>

            </div>

        </div>

    </div>

</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

const map = L.map('map').setView([20,0],2);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
    attribution:'© OpenStreetMap'
}).addTo(map);

L.marker([52.52,13.40]).addTo(map).bindPopup("<b>Germany</b>");
L.marker([-6.20,106.80]).addTo(map).bindPopup("<b>Indonesia</b>");
L.marker([39.90,116.40]).addTo(map).bindPopup("<b>China</b>");
L.marker([-35.28,149.13]).addTo(map).bindPopup("<b>Australia</b>");

</script>

@endsection