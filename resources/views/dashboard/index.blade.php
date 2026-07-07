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
            {{ $country && $country->id == $item->id ? 'selected' : '' }}>
            {{ $item->name }}
        </option>

        @endforeach

    </select>
</form>

<div class="grid grid-cols-3 gap-6 mt-6">

    <div class="bg-white shadow rounded-xl p-5">
        <h2>GDP</h2>
        <p class="text-2xl font-bold">
            {{ $country->gdp }}
        </p>
    </div>

    <div class="bg-white shadow rounded-xl p-5">
        <h2>Inflation</h2>
        <p class="text-2xl font-bold">
            {{ $country->inflation }} %
        </p>
    </div>

    <div class="bg-white shadow rounded-xl p-5">
        <h2>Population</h2>
        <p class="text-2xl font-bold">
            {{ $country->population }}
        </p>
    </div>

    <div class="bg-white shadow rounded-xl p-5">
        <h2>Currency</h2>
        <p class="text-2xl font-bold">
            {{ $country->currency }}
        </p>
    </div>

    <div class="bg-white shadow rounded-xl p-5">
        <h2>Weather</h2>
        <p class="text-2xl font-bold">
            Belum tersedia
        </p>
    </div>

</div>

<h2 class="text-2xl font-bold mt-8">
    Risk Scoring Engine
</h2>

<div class="bg-white shadow rounded-xl p-6 mt-4">

    <p>Weather : -</p>
    <p>Inflation : -</p>
    <p>Exchange Rate : -</p>
    <p>News Sentiment : -</p>

    <hr class="my-4">

    <h1 class="text-3xl font-bold">
        {{ $country->name }}
    </h1>

    <h2 class="text-xl mt-2">
        Risk Score belum dihitung
    </h2>

</div>

@else

<div class="bg-yellow-100 border border-yellow-400 p-5 rounded-lg">
    <h2 class="text-xl font-bold">Belum ada data negara</h2>
    <p>Silakan isi tabel <b>countries</b> terlebih dahulu.</p>
</div>

@endif

@endsection