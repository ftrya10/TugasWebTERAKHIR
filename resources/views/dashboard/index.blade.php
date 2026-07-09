@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Global Country Dashboard
</h1>

@if($countries->count())

<form method="GET">
    <select name="country" class="border rounded p-2" onchange="this.form.submit()">

        @foreach($countries as $item)

        <option value="{{ $item->id }}"
            {{ $country->id == $item->id ? 'selected' : '' }}>
            {{ $item->name }}
        </option>

        @endforeach

    </select>
</form>

<div class="grid grid-cols-3 gap-6 mt-6">

    <div class="bg-white shadow rounded-xl p-5">
        <h2 class="font-semibold">GDP</h2>
        <p class="text-2xl font-bold">
            {{ $country->gdp }}
        </p>
    </div>

    <div class="bg-white shadow rounded-xl p-5">
        <h2 class="font-semibold">Inflation</h2>
        <p class="text-2xl font-bold">
            {{ $country->inflation }} %
        </p>
    </div>

    <div class="bg-white shadow rounded-xl p-5">
        <h2 class="font-semibold">Population</h2>
        <p class="text-2xl font-bold">
            {{ $country->population }}
        </p>
    </div>

    <div class="bg-white shadow rounded-xl p-5">
        <h2 class="font-semibold">Currency</h2>
        <p class="text-2xl font-bold">
            {{ $country->currency }}
        </p>
    </div>

    <div class="bg-white shadow rounded-xl p-5">
        <h2 class="font-semibold">Current Weather</h2>

        @if($country->weather)

            <p class="text-xl font-bold">
                {{ $country->weather->temperature }}
            </p>

            <p>
                {{ $country->weather->condition }}
            </p>

        @else

            <p>No weather data.</p>

        @endif

    </div>

    <div class="bg-white shadow rounded-xl p-5">
        <h2 class="font-semibold">Exchange Rate</h2>

        @if($country->exchangeRate)

            <p class="text-xl font-bold">
                {{ $country->exchangeRate->currency }}
            </p>

            <p>
                {{ $country->exchangeRate->rate }}
            </p>

        @else

            <p>No exchange data.</p>

        @endif

    </div>

</div>


<h2 class="text-2xl font-bold mt-8">
    Risk Scoring Engine
</h2>

<div class="bg-white shadow rounded-xl p-6 mt-4">

@if($country->riskScore)

    <p>Weather Score :
        <b>{{ $country->riskScore->weather_score }}</b>
    </p>

    <p>Inflation Score :
        <b>{{ $country->riskScore->inflation_score }}</b>
    </p>

    <p>Exchange Score :
        <b>{{ $country->riskScore->exchange_score }}</b>
    </p>

    <p>News Score :
        <b>{{ $country->riskScore->news_score }}</b>
    </p>

    <hr class="my-4">

    <h2 class="text-3xl font-bold">

        Total Risk :
        {{ $country->riskScore->total_score }}

    </h2>

    <h3 class="text-xl mt-3">

        Status :
        {{ $country->riskScore->status }}

    </h3>

@else

    <p>Risk score belum tersedia.</p>

@endif

</div>

<h2 class="text-2xl font-bold mt-8">
    Latest News
</h2>

<div class="bg-white shadow rounded-xl p-6 mt-4">

@if($country->news)

    <h3 class="font-bold">
        {{ $country->news->title }}
    </h3>

    <p>
        Sentiment :
        {{ $country->news->sentiment }}
    </p>

@else

    <p>Tidak ada berita.</p>

@endif

</div>

@else

<div class="bg-yellow-100 border border-yellow-400 p-5 rounded">

Belum ada data negara.

</div>

@endif

@endsection