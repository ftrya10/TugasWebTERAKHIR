@extends('layouts.app')

@section('title', 'GlobalTrade Dashboard')

@section('content')
<div class="p-4">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-5">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                GlobalTrade Dashboard
            </h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Global Supply Chain Intelligence Platform
            </p>
        </div>

        <span class="text-xs text-gray-400">
            Last updated: {{ now()->format('d M Y H:i') }}
        </span>
    </div>


    {{-- RINGKASAN UTAMA --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">

        {{-- COUNTRIES --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border">
            <p class="text-xs text-gray-500 uppercase font-bold">
                🌍 Total Countries
            </p>

            <p class="text-2xl font-bold text-green-600">
                {{ $stats->total_countries ?? 0 }}
            </p>

            <p class="text-xs text-gray-500 mt-1">
                Negara dipantau
            </p>
        </div>


        {{-- ACTIVE PORTS --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border">
            <p class="text-xs text-gray-500 uppercase font-bold">
                ⚓ Active Ports
            </p>

            <p class="text-2xl font-bold text-purple-600">
                {{ $stats->active_ports ?? 0 }}
            </p>

            <p class="text-xs text-gray-500 mt-1">
                Dari {{ $stats->total_ports ?? 0 }} pelabuhan
            </p>
        </div>


        {{-- WEATHER RISK --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border">
            <p class="text-xs text-gray-500 uppercase font-bold">
                🌦️ Weather Risk
            </p>

            <p class="text-2xl font-bold text-orange-600">
                {{ $stats->weather_risk ?? 0 }}
            </p>

            <p class="text-xs text-gray-500 mt-1">
                Negara berisiko cuaca tinggi
            </p>
        </div>


        {{-- SUPPLY CHAIN RISK --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border">
            <p class="text-xs text-gray-500 uppercase font-bold">
                🚢 Supply Chain Risk
            </p>

            <p class="text-2xl font-bold
                @if(($stats->overall_risk ?? 'Low') == 'Critical')
                    text-red-700
                @elseif(($stats->overall_risk ?? 'Low') == 'High')
                    text-red-500
                @elseif(($stats->overall_risk ?? 'Low') == 'Medium')
                    text-yellow-500
                @else
                    text-green-600
                @endif">

                {{ $stats->overall_risk ?? 'Low' }}
            </p>

            <p class="text-xs text-gray-500 mt-1">
                Score: {{ $stats->supply_chain_risk_score ?? 0 }}
            </p>
        </div>

    </div>


    {{-- INDIKATOR STUDI KASUS --}}
    <div class="mb-5">

        <h2 class="text-sm font-bold text-gray-900 dark:text-white mb-3">
            📊 Supply Chain Risk Indicators
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">

            {{-- WEATHER --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border">
                <p class="text-xs text-gray-500">
                    🌦️ Weather
                </p>

                <p class="text-xl font-bold mt-2">
                    {{ $stats->average_weather_score ?? 0 }}
                </p>

                <p class="text-xs text-gray-500">
                    Risk Score
                </p>
            </div>


            {{-- EXCHANGE --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border">
                <p class="text-xs text-gray-500">
                    💱 Exchange Rate
                </p>

                <p class="text-xl font-bold mt-2">
                    {{ $stats->average_exchange_score ?? 0 }}
                </p>

                <p class="text-xs text-gray-500">
                    Risk Score
                </p>
            </div>


            {{-- INFLATION --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border">
                <p class="text-xs text-gray-500">
                    📈 Inflation
                </p>

                <p class="text-xl font-bold mt-2">
                    {{ $stats->average_inflation_score ?? 0 }}
                </p>

                <p class="text-xs text-gray-500">
                    Risk Score
                </p>
            </div>


            {{-- GEOPOLITICAL --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border">
                <p class="text-xs text-gray-500">
                    ⚠️ Geopolitical
                </p>

                <p class="text-xl font-bold mt-2">
                    {{ $stats->average_geopolitical_risk ?? 0 }}
                </p>

                <p class="text-xs text-gray-500">
                    Risk Score
                </p>
            </div>


            {{-- PORT --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border">
                <p class="text-xs text-gray-500">
                    ⚓ Port Congestion
                </p>

                <p class="text-xl font-bold mt-2">
                    {{ $stats->port_congestion_score ?? 0 }}%
                </p>

                <p class="text-xs text-gray-500">
                    {{ $stats->congested_ports ?? 0 }} ports affected
                </p>
            </div>

        </div>

    </div>


    {{-- RISK SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-5">

        {{-- HIGH RISK --}}
        <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 border border-red-200">
            <p class="text-xs font-bold text-red-600 uppercase">
                🔴 High Risk Countries
            </p>

            <p class="text-3xl font-bold text-red-600 mt-2">
                {{ $highRisk ?? 0 }}
            </p>
        </div>


        {{-- MEDIUM RISK --}}
        <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4 border border-yellow-200">
            <p class="text-xs font-bold text-yellow-600 uppercase">
                🟡 Medium Risk Countries
            </p>

            <p class="text-3xl font-bold text-yellow-600 mt-2">
                {{ $mediumRisk ?? 0 }}
            </p>
        </div>


        {{-- LOW RISK --}}
        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200">
            <p class="text-xs font-bold text-green-600 uppercase">
                🟢 Low Risk Countries
            </p>

            <p class="text-3xl font-bold text-green-600 mt-2">
                {{ $lowRisk ?? 0 }}
            </p>
        </div>

    </div>


    {{-- INFORMASI EKONOMI DAN PELABUHAN --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-5">

        {{-- ECONOMIC OVERVIEW --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow border">

            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <p class="text-sm font-bold text-gray-900 dark:text-white">
                    📈 Economic Overview
                </p>
            </div>

            <div class="p-4 space-y-3">

                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">
                        Average Inflation
                    </span>

                    <span class="font-bold">
                        {{ $stats->average_inflation ?? 0 }}%
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">
                        Highest GDP
                    </span>

                    <span class="font-bold">
                        {{ $stats->highest_gdp_country ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">
                        Total Population
                    </span>

                    <span class="font-bold">
                        {{ number_format($stats->total_population ?? 0) }}
                    </span>
                </div>

            </div>
        </div>


        {{-- PORT OVERVIEW --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow border">

            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <p class="text-sm font-bold text-gray-900 dark:text-white">
                    ⚓ Port Overview
                </p>
            </div>

            <div class="p-4 space-y-3">

                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">
                        Total Ports
                    </span>

                    <span class="font-bold">
                        {{ $stats->total_ports ?? 0 }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">
                        Active Ports
                    </span>

                    <span class="font-bold text-green-600">
                        {{ $stats->active_ports ?? 0 }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">
                        Congested / Delayed
                    </span>

                    <span class="font-bold text-red-600">
                        {{ $stats->congested_ports ?? 0 }}
                    </span>
                </div>

            </div>
        </div>

    </div>


    {{-- RECENT NEWS --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">

        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">

            <p class="text-sm font-bold text-gray-900 dark:text-white">
                📰 Recent Supply Chain & Geopolitical News
            </p>

            <span class="text-xs text-gray-500">
                Total: {{ $stats->total_articles ?? 0 }}
            </span>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 dark:bg-gray-700/50">

                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                            Country
                        </th>

                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                            News
                        </th>

                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                            Sentiment
                        </th>

                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                            Risk Score
                        </th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                    @forelse($recentNews ?? [] as $news)

                    <tr>

                        <td class="px-3 py-3 font-medium">
                            {{ $news->country->name ?? '-' }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $news->title }}
                        </td>

                        <td class="px-3 py-3">
                            {{ ucfirst($news->sentiment ?? 'Unknown') }}
                        </td>

                        <td class="px-3 py-3 font-bold">
                            {{ $news->news_score ?? 0 }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="4" class="px-3 py-5 text-center text-gray-500">
                            Belum ada berita tersedia.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection