@extends('layouts.app')

@section('title', ($countryData['name'] ?? $country->name) . ' - Country Intelligence')

@section('content')

@php
/*
|--------------------------------------------------------------------------
| SAFE DATA
|--------------------------------------------------------------------------
*/

```
$countryName =
    $countryData['name']
    ?? $country->name
    ?? 'Unknown Country';

$officialName =
    $countryData['official_name']
    ?? $countryName;

$region =
    $countryData['region']
    ?? $country->region
    ?? '-';

$subregion =
    $countryData['subregion']
    ?? '-';

$capital =
    $countryData['capital']
    ?? '-';

$languages =
    $countryData['languages']
    ?? '-';

$population =
    $countryData['population']
    ?? $country->population
    ?? 0;

$gdp =
    $countryData['gdp']
    ?? $country->gdp
    ?? null;

$inflation =
    $countryData['inflation']
    ?? $country->inflation
    ?? null;

$unemployment =
    $countryData['unemployment']
    ?? null;

$economicYear =
    $countryData['economic_year']
    ?? null;

$flag =
    $countryData['flag']
    ?? $country->flag
    ?? '';

$latlng =
    $countryData['latlng']
    ?? [
        $country->latitude ?? 0,
        $country->longitude ?? 0,
    ];

$latitude =
    $latlng[0]
    ?? $country->latitude
    ?? 0;

$longitude =
    $latlng[1]
    ?? $country->longitude
    ?? 0;


/*
|--------------------------------------------------------------------------
| CURRENCY
|--------------------------------------------------------------------------
*/

$currencies =
    $countryData['currencies']
    ?? [];

$currencyName = '-';
$currencyCode = '-';
$currencySymbol = '';

if (!empty($currencies)) {

    $currencyCode =
        array_key_first($currencies);

    $currencyInfo =
        $currencies[$currencyCode]
        ?? [];

    $currencyName =
        $currencyInfo['name']
        ?? $country->currency
        ?? '-';

    $currencySymbol =
        $currencyInfo['symbol']
        ?? '';
}


/*
|--------------------------------------------------------------------------
| RISK
|--------------------------------------------------------------------------
*/

$riskScoreValue =
    (float) (
        optional($riskScore)->total_score
        ?? 0
    );

$riskStatus =
    $riskStatus
    ?? 'Low';

$riskStatusLower =
    strtolower($riskStatus);


$riskStatusClass =
    $riskScoreValue >= 70
        ? 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-400'
        : (
            $riskScoreValue >= 50
                ? 'bg-orange-100 text-orange-700 dark:bg-orange-950/40 dark:text-orange-400'
                : (
                    $riskScoreValue >= 30
                        ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-950/40 dark:text-yellow-400'
                        : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400'
                )
        );


$riskBarClass =
    $riskScoreValue >= 70
        ? 'bg-red-500'
        : (
            $riskScoreValue >= 50
                ? 'bg-orange-500'
                : (
                    $riskScoreValue >= 30
                        ? 'bg-yellow-500'
                        : 'bg-emerald-500'
                )
        );


/*
|--------------------------------------------------------------------------
| RISK BREAKDOWN
|--------------------------------------------------------------------------
*/

$weatherRisk =
    (float) (
        optional($riskScore)->weather_score
        ?? 0
    );

$inflationRisk =
    (float) (
        optional($riskScore)->inflation_score
        ?? 0
    );

$exchangeRisk =
    (float) (
        optional($riskScore)->exchange_score
        ?? 0
    );

$newsRisk =
    (float) (
        optional($riskScore)->news_score
        ?? 0
    );

$portRisk =
    (float) (
        optional($riskScore)->port_score
        ?? 0
    );


/*
|--------------------------------------------------------------------------
| WEATHER
|--------------------------------------------------------------------------
*/

$temperature =
    optional($weather)->temperature_2m;

$humidity =
    optional($weather)->relative_humidity_2m;

$rain =
    optional($weather)->rain;

$windSpeed =
    optional($weather)->wind_speed_10m;


/*
|--------------------------------------------------------------------------
| EXCHANGE
|--------------------------------------------------------------------------
*/

$exchangeValue =
    optional($exchangeRate)->exchange_rate
    ?? optional($exchangeRate)->rate
    ?? optional($exchangeRate)->value
    ?? null;


/*
|--------------------------------------------------------------------------
| NEWS
|--------------------------------------------------------------------------
*/

$newsItems =
    $news
    ?? collect();


/*
|--------------------------------------------------------------------------
| PORTS
|--------------------------------------------------------------------------
*/

$portItems =
    $ports
    ?? collect();
```

@endphp

<div class="min-h-screen bg-slate-50 dark:bg-slate-950">

```
{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">

    <div class="max-w-7xl mx-auto px-4 lg:px-6 py-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

            <div class="flex items-center gap-4">

                @if($flag)

                    <img
                        src="{{ $flag }}"
                        alt="{{ $countryName }} Flag"
                        class="w-20 h-14 object-cover rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm"
                    >

                @else

                    <div class="w-20 h-14 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-3xl">
                        🌍
                    </div>

                @endif


                <div>

                    <p class="text-xs font-black uppercase tracking-widest text-blue-600 dark:text-blue-400">
                        Country Intelligence Center
                    </p>

                    <h1 class="mt-1 text-3xl lg:text-4xl font-black text-slate-900 dark:text-white">
                        {{ $countryName }}
                    </h1>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        {{ $officialName }}
                    </p>

                </div>

            </div>


            <div class="flex flex-wrap gap-3">

                <a
                    href="{{ route('countries.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-200 dark:border-slate-700 px-4 py-3 text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition"
                >
                    ← Countries
                </a>

                <a
                    href="{{ route('risk.show', $country->id) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-slate-900 dark:bg-white px-4 py-3 text-sm font-bold text-white dark:text-slate-900 hover:opacity-90 transition"
                >
                    Analyze Risk →
                </a>

            </div>

        </div>

    </div>

</div>


<div class="max-w-7xl mx-auto px-4 lg:px-6 py-6">


    {{-- ========================================================= --}}
    {{-- COUNTRY OVERVIEW --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">


        {{-- BASIC INFORMATION --}}

        <div class="lg:col-span-2 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">

            <div class="flex items-center justify-between mb-6">

                <div>

                    <p class="text-xs font-black uppercase tracking-widest text-blue-600 dark:text-blue-400">
                        Country Profile
                    </p>

                    <h2 class="mt-1 text-xl font-black text-slate-900 dark:text-white">
                        General Information
                    </h2>

                </div>

                <span class="rounded-full bg-blue-50 dark:bg-blue-950/40 px-3 py-1 text-xs font-bold text-blue-600 dark:text-blue-400">
                    {{ strtoupper($country->code ?? '-') }}
                </span>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">


                <div class="rounded-xl bg-slate-50 dark:bg-slate-800/60 p-4">

                    <p class="text-xs text-slate-400 font-bold">
                        Official Name
                    </p>

                    <p class="mt-2 font-bold text-slate-900 dark:text-white">
                        {{ $officialName }}
                    </p>

                </div>


                <div class="rounded-xl bg-slate-50 dark:bg-slate-800/60 p-4">

                    <p class="text-xs text-slate-400 font-bold">
                        Capital
                    </p>

                    <p class="mt-2 font-bold text-slate-900 dark:text-white">
                        {{ $capital }}
                    </p>

                </div>


                <div class="rounded-xl bg-slate-50 dark:bg-slate-800/60 p-4">

                    <p class="text-xs text-slate-400 font-bold">
                        Region
                    </p>

                    <p class="mt-2 font-bold text-slate-900 dark:text-white">
                        {{ $region }}
                    </p>

                </div>


                <div class="rounded-xl bg-slate-50 dark:bg-slate-800/60 p-4">

                    <p class="text-xs text-slate-400 font-bold">
                        Subregion
                    </p>

                    <p class="mt-2 font-bold text-slate-900 dark:text-white">
                        {{ $subregion }}
                    </p>

                </div>


                <div class="rounded-xl bg-slate-50 dark:bg-slate-800/60 p-4">

                    <p class="text-xs text-slate-400 font-bold">
                        Languages
                    </p>

                    <p class="mt-2 font-bold text-slate-900 dark:text-white">
                        {{ $languages }}
                    </p>

                </div>


                <div class="rounded-xl bg-slate-50 dark:bg-slate-800/60 p-4">

                    <p class="text-xs text-slate-400 font-bold">
                        Coordinates
                    </p>

                    <p class="mt-2 font-bold text-slate-900 dark:text-white">
                        {{ number_format((float) $latitude, 4) }},
                        {{ number_format((float) $longitude, 4) }}
                    </p>

                </div>

            </div>

        </div>


        {{-- RISK SUMMARY --}}

        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">

            <p class="text-xs font-black uppercase tracking-widest text-red-500">
                Supply Chain Risk
            </p>

            <h2 class="mt-1 text-xl font-black text-slate-900 dark:text-white">
                Risk Intelligence
            </h2>


            <div class="mt-6 flex items-end justify-between">

                <div>

                    <p class="text-5xl font-black text-slate-900 dark:text-white">
                        {{ number_format($riskScoreValue, 1) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Risk Score / 100
                    </p>

                </div>


                <span class="rounded-full px-4 py-2 text-xs font-black uppercase {{ $riskStatusClass }}">
                    {{ $riskStatus }}
                </span>

            </div>


            <div class="mt-5">

                <div class="h-2 w-full rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">

                    <div
                        class="h-full rounded-full {{ $riskBarClass }}"
                        style="width: {{ min(100, $riskScoreValue) }}%"
                    ></div>

                </div>

            </div>


            <div class="mt-6 space-y-3">


                <div class="flex justify-between text-sm">

                    <span class="text-slate-500">
                        Weather
                    </span>

                    <strong class="text-slate-900 dark:text-white">
                        {{ number_format($weatherRisk, 1) }}
                    </strong>

                </div>


                <div class="flex justify-between text-sm">

                    <span class="text-slate-500">
                        Inflation
                    </span>

                    <strong class="text-slate-900 dark:text-white">
                        {{ number_format($inflationRisk, 1) }}
                    </strong>

                </div>


                <div class="flex justify-between text-sm">

                    <span class="text-slate-500">
                        Currency
                    </span>

                    <strong class="text-slate-900 dark:text-white">
                        {{ number_format($exchangeRisk, 1) }}
                    </strong>

                </div>


                <div class="flex justify-between text-sm">

                    <span class="text-slate-500">
                        News
                    </span>

                    <strong class="text-slate-900 dark:text-white">
                        {{ number_format($newsRisk, 1) }}
                    </strong>

                </div>


                <div class="flex justify-between text-sm">

                    <span class="text-slate-500">
                        Ports
                    </span>

                    <strong class="text-slate-900 dark:text-white">
                        {{ number_format($portRisk, 1) }}
                    </strong>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ECONOMIC INTELLIGENCE --}}
    {{-- ========================================================= --}}

    <div class="mb-6">

        <div class="mb-4">

            <p class="text-xs font-black uppercase tracking-widest text-purple-600 dark:text-purple-400">
                Economic Intelligence
            </p>

            <h2 class="mt-1 text-2xl font-black text-slate-900 dark:text-white">
                Key Economic Indicators
            </h2>

        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">


            {{-- GDP --}}

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-sm">

                <p class="text-xs font-bold uppercase text-slate-400">
                    GDP
                </p>

                <p class="mt-3 text-2xl font-black text-purple-600">

                    @if($gdp !== null)

                        ${{ number_format((float) $gdp, 0) }}

                    @else

                        N/A

                    @endif

                </p>

                @if($economicYear)

                    <p class="mt-1 text-xs text-slate-400">
                        World Bank · {{ $economicYear }}
                    </p>

                @endif

            </div>


            {{-- INFLATION --}}

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-sm">

                <p class="text-xs font-bold uppercase text-slate-400">
                    Inflation
                </p>

                <p class="mt-3 text-2xl font-black text-orange-600">

                    @if($inflation !== null)

                        {{ number_format((float) $inflation, 2) }}%

                    @else

                        N/A

                    @endif

                </p>

                @if($economicYear)

                    <p class="mt-1 text-xs text-slate-400">
                        World Bank · {{ $economicYear }}
                    </p>

                @endif

            </div>


            {{-- POPULATION --}}

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-sm">

                <p class="text-xs font-bold uppercase text-slate-400">
                    Population
                </p>

                <p class="mt-3 text-2xl font-black text-blue-600">
                    {{ number_format((int) $population) }}
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Current population estimate
                </p>

            </div>


            {{-- UNEMPLOYMENT --}}

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-sm">

                <p class="text-xs font-bold uppercase text-slate-400">
                    Unemployment
                </p>

                <p class="mt-3 text-2xl font-black text-red-600">

                    @if($unemployment !== null)

                        {{ number_format((float) $unemployment, 2) }}%

                    @else

                        N/A

                    @endif

                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Labor market indicator
                </p>

            </div>


            {{-- CURRENCY --}}

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-sm">

                <p class="text-xs font-bold uppercase text-slate-400">
                    Currency
                </p>

                <p class="mt-3 text-xl font-black text-emerald-600">
                    {{ $currencyCode }}
                    @if($currencySymbol)
                        ({{ $currencySymbol }})
                    @endif
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    {{ $currencyName }}
                </p>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- WEATHER + EXCHANGE --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">


        {{-- WEATHER --}}

        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">

            <div class="flex items-center justify-between mb-6">

                <div>

                    <p class="text-xs font-black uppercase tracking-widest text-sky-600">
                        Live Monitoring
                    </p>

                    <h2 class="mt-1 text-xl font-black text-slate-900 dark:text-white">
                        Current Weather
                    </h2>

                </div>

                <span class="text-3xl">
                    🌦️
                </span>

            </div>


            @if($weather)

                <div class="grid grid-cols-2 gap-4">


                    <div class="rounded-xl bg-sky-50 dark:bg-sky-950/30 p-4">

                        <p class="text-xs font-bold text-sky-600">
                            Temperature
                        </p>

                        <p class="mt-2 text-2xl font-black text-slate-900 dark:text-white">

                            {{ $temperature ?? '-' }}°C

                        </p>

                    </div>


                    <div class="rounded-xl bg-blue-50 dark:bg-blue-950/30 p-4">

                        <p class="text-xs font-bold text-blue-600">
                            Humidity
                        </p>

                        <p class="mt-2 text-2xl font-black text-slate-900 dark:text-white">

                            {{ $humidity ?? '-' }}%

                        </p>

                    </div>


                    <div class="rounded-xl bg-indigo-50 dark:bg-indigo-950/30 p-4">

                        <p class="text-xs font-bold text-indigo-600">
                            Rain
                        </p>

                        <p class="mt-2 text-2xl font-black text-slate-900 dark:text-white">

                            {{ $rain ?? '-' }} mm

                        </p>

                    </div>


                    <div class="rounded-xl bg-purple-50 dark:bg-purple-950/30 p-4">

                        <p class="text-xs font-bold text-purple-600">
                            Wind Speed
                        </p>

                        <p class="mt-2 text-2xl font-black text-slate-900 dark:text-white">

                            {{ $windSpeed ?? '-' }} km/h

                        </p>

                    </div>

                </div>

            @else

                <div class="rounded-xl bg-slate-50 dark:bg-slate-800 p-6 text-center">

                    <p class="text-3xl">
                        🌤️
                    </p>

                    <p class="mt-3 font-bold text-slate-700 dark:text-slate-300">
                        Weather data unavailable
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        No current weather data is available for this country.
                    </p>

                </div>

            @endif

        </div>


        {{-- EXCHANGE RATE --}}

        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">

            <div class="flex items-center justify-between mb-6">

                <div>

                    <p class="text-xs font-black uppercase tracking-widest text-emerald-600">
                        Currency Intelligence
                    </p>

                    <h2 class="mt-1 text-xl font-black text-slate-900 dark:text-white">
                        Exchange Rate
                    </h2>

                </div>

                <span class="text-3xl">
                    💱
                </span>

            </div>


            @if($exchangeRate)

                <div class="rounded-2xl bg-emerald-50 dark:bg-emerald-950/30 p-6">

                    <p class="text-sm text-emerald-700 dark:text-emerald-400">
                        Current exchange indicator
                    </p>

                    <p class="mt-3 text-4xl font-black text-emerald-600">

                        {{ $exchangeValue !== null
                            ? number_format((float) $exchangeValue, 4)
                            : 'N/A'
                        }}

                    </p>

                    <p class="mt-2 text-xs text-slate-500">
                        Currency: {{ $currencyCode }}
                    </p>

                </div>

            @else

                <div class="rounded-xl bg-slate-50 dark:bg-slate-800 p-6 text-center">

                    <p class="text-3xl">
                        💱
                    </p>

                    <p class="mt-3 font-bold text-slate-700 dark:text-slate-300">
                        Exchange data unavailable
                    </p>

                </div>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- RISK BREAKDOWN --}}
    {{-- ========================================================= --}}

    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm mb-6">

        <div class="mb-6">

            <p class="text-xs font-black uppercase tracking-widest text-red-600">
                Risk Scoring Engine
            </p>

            <h2 class="mt-1 text-2xl font-black text-slate-900 dark:text-white">
                Supply Chain Risk Breakdown
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Risk exposure calculated from weather, inflation, currency, news, and port conditions.
            </p>

        </div>


        <div class="space-y-5">


            @foreach([
                ['name' => 'Weather Risk', 'value' => $weatherRisk, 'color' => 'bg-blue-500'],
                ['name' => 'Inflation Risk', 'value' => $inflationRisk, 'color' => 'bg-yellow-500'],
                ['name' => 'Currency Risk', 'value' => $exchangeRisk, 'color' => 'bg-purple-500'],
                ['name' => 'News / Geopolitical Risk', 'value' => $newsRisk, 'color' => 'bg-pink-500'],
                ['name' => 'Port Risk', 'value' => $portRisk, 'color' => 'bg-slate-500'],
            ] as $factor)

                <div>

                    <div class="flex items-center justify-between mb-2">

                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300">
                            {{ $factor['name'] }}
                        </span>

                        <span class="text-sm font-black text-slate-900 dark:text-white">
                            {{ number_format($factor['value'], 1) }} / 100
                        </span>

                    </div>


                    <div class="h-2.5 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">

                        <div
                            class="h-full rounded-full {{ $factor['color'] }}"
                            style="width: {{ min(100, $factor['value']) }}%"
                        ></div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MAP --}}
    {{-- ========================================================= --}}

    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm mb-6">

        <div class="mb-5">

            <p class="text-xs font-black uppercase tracking-widest text-blue-600">
                Geographic Intelligence
            </p>

            <h2 class="mt-1 text-2xl font-black text-slate-900 dark:text-white">
                Country Location
            </h2>

        </div>


        <div
            id="countryMap"
            class="w-full h-[400px] rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800"
        ></div>

    </div>


    {{-- ========================================================= --}}
    {{-- NEWS INTELLIGENCE --}}
    {{-- ========================================================= --}}

    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm mb-6">

        <div class="p-6 border-b border-slate-200 dark:border-slate-800">

            <p class="text-xs font-black uppercase tracking-widest text-pink-600">
                News Intelligence
            </p>

            <h2 class="mt-1 text-2xl font-black text-slate-900 dark:text-white">
                Latest Country Intelligence
            </h2>

        </div>


        <div class="p-6">

            @if($newsItems && $newsItems->count())

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    @foreach($newsItems->take(10) as $article)

                        <div class="rounded-xl border border-slate-200 dark:border-slate-700 p-5 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">

                            <p class="text-xs font-bold text-pink-600">
                                {{ $article->source ?? 'News Intelligence' }}
                            </p>

                            <h3 class="mt-2 font-black text-slate-900 dark:text-white">

                                {{ $article->title
                                    ?? $article->headline
                                    ?? 'Untitled Article'
                                }}

                            </h3>

                            @if($article->description ?? null)

                                <p class="mt-2 text-sm text-slate-500 line-clamp-3">
                                    {{ $article->description }}
                                </p>

                            @endif

                            @if($article->url ?? null)

                                <a
                                    href="{{ $article->url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex mt-4 text-xs font-bold text-blue-600 hover:underline"
                                >
                                    Read Article →
                                </a>

                            @endif

                        </div>

                    @endforeach

                </div>

            @else

                <div class="py-10 text-center">

                    <div class="text-4xl">
                        📰
                    </div>

                    <p class="mt-3 font-bold text-slate-700 dark:text-slate-300">
                        No news intelligence available
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        News related to trade, logistics, shipping, and economy will appear here.
                    </p>

                </div>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PORT INTELLIGENCE --}}
    {{-- ========================================================= --}}

    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm">

        <div class="p-6 border-b border-slate-200 dark:border-slate-800">

            <p class="text-xs font-black uppercase tracking-widest text-slate-600 dark:text-slate-400">
                Port Intelligence
            </p>

            <h2 class="mt-1 text-2xl font-black text-slate-900 dark:text-white">
                Maritime & Logistics Infrastructure
            </h2>

        </div>


        <div class="overflow-x-auto">

            @if($portItems && $portItems->count())

                <table class="w-full text-sm">

                    <thead class="bg-slate-50 dark:bg-slate-800/60">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-400">
                                Port
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-400">
                                Location
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-400">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                        @foreach($portItems as $port)

                            @php

                                $portStatus =
                                    strtolower(
                                        trim(
                                            $port->status
                                            ?? 'unknown'
                                        )
                                    );

                                $portClass =
                                    in_array(
                                        $portStatus,
                                        [
                                            'critical',
                                            'congested'
                                        ],
                                        true
                                    )
                                        ? 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-400'
                                        : (
                                            $portStatus === 'delayed'
                                                ? 'bg-orange-100 text-orange-700 dark:bg-orange-950/40 dark:text-orange-400'
                                                : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400'
                                        );

                            @endphp


                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">

                                <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">

                                    {{ $port->name
                                        ?? $port->port_name
                                        ?? '-'
                                    }}

                                </td>


                                <td class="px-6 py-4 text-slate-500">

                                    {{ $port->city
                                        ?? $port->location
                                        ?? $port->country
                                        ?? '-'
                                    }}

                                </td>


                                <td class="px-6 py-4">

                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-black uppercase {{ $portClass }}">

                                        {{ ucfirst($portStatus) }}

                                    </span>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="py-12 text-center">

                    <div class="text-4xl">
                        ⚓
                    </div>

                    <p class="mt-3 font-bold text-slate-700 dark:text-slate-300">
                        No port data available
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        Port infrastructure data for this country is not available yet.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>
```

</div>

{{-- ========================================================= --}}
{{-- LEAFLET MAP --}}
{{-- ========================================================= --}}

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const latitude =
            Number(@json($latitude));

        const longitude =
            Number(@json($longitude));


        if (
            !latitude &&
            !longitude
        ) {

            return;

        }


        const map =
            L.map(
                'countryMap'
            ).setView(
                [
                    latitude,
                    longitude
                ],
                5
            );


        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                maxZoom: 18,
                attribution:
                    '&copy; OpenStreetMap contributors'
            }
        ).addTo(map);


        L.marker(
            [
                latitude,
                longitude
            ]
        )
        .addTo(map)
        .bindPopup(
            `<strong>{{ $countryName }}</strong><br>
             {{ $capital }}`
        )
        .openPopup();

    }

);

</script>

@endsection
