@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Exchange Rate
</h1>

{{-- Summary Cards --}}
<div class="grid grid-cols-4 gap-6 mb-6">

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Currencies</p>
        <h2 class="text-3xl font-bold">
            {{ $countries->filter(fn($c) => !empty($c->name) && $c->name != '-' && trim($c->name) != '')->count() }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Highest Rate</p>
        <h2 class="text-2xl font-bold">
            {{ optional($countries->filter(fn($c) => !empty($c->name) && $c->name != '-' && trim($c->name) != '')->sortByDesc(fn($c)=>optional($c->exchangeRate)->rate)->first()->exchangeRate)->currency ?? '-' }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Lowest Rate</p>
        <h2 class="text-2xl font-bold">
            {{ optional($countries->filter(fn($c) => !empty($c->name) && $c->name != '-' && trim($c->name) != '')->sortBy(fn($c)=>optional($c->exchangeRate)->rate)->first()->exchangeRate)->currency ?? '-' }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Updated</p>
        <h2 class="text-xl font-bold text-green-600">
            Today
        </h2>
    </div>

</div>

{{-- Search --}}
<div class="flex justify-end mb-4">

    <input
        type="text"
        placeholder="Search Country..."
        class="border rounded-lg px-4 py-2 w-64">

</div>

<div class="bg-white rounded-xl shadow p-6">

<table class="table-auto w-full border-collapse">

<thead class="bg-gray-200">

<tr>

<th class="border p-3">Country</th>
<th class="border p-3">Currency</th>
<th class="border p-3">Exchange Rate</th>
<th class="border p-3">Exchange Score</th>
<th class="border p-3">Status</th>
<th class="border p-3">Action</th>

</tr>

</thead>

<tbody>

@foreach($countries as $country)
    {{-- VALIDASI: Skip baris jika nama negara kosong atau hanya strip --}}
    @if(empty($country->name) || $country->name == '-' || trim($country->name) == '')
        @continue
    @endif

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">
    {{ $country->name }}
</td>

<td class="border p-3">
    {{ optional($country->exchangeRate)->currency }}
</td>

<td class="border p-3">
    {{ optional($country->exchangeRate)->rate }}
</td>

<td class="border p-3 font-bold">
    {{ optional($country->exchangeRate)->exchange_score }}
</td>

<td class="border p-3">

    @php
        $score = optional($country->exchangeRate)->exchange_score;
    @endphp

    @if($score <= 15)
        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
            Stable
        </span>

    @elseif($score <= 25)
        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
            Moderate
        </span>

    @else
        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
            Volatile
        </span>
    @endif

</td>

<td class="border p-3">

    <a href="{{ route('dashboard', ['country' => $country->id]) }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
        View
    </a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection