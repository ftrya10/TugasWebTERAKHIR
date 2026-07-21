@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Global News
</h1>

{{-- Summary --}}
<div class="grid grid-cols-4 gap-6 mb-6">

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Countries</p>
        <h2 class="text-3xl font-bold">
            {{ $countries->filter(fn($c) => !empty($c->name) && $c->name != '-' && trim($c->name) != '')->count() }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Positive News</p>
        <h2 class="text-3xl font-bold text-green-600">
            {{ $countries->filter(fn($c) => !empty($c->name) && $c->name != '-' && trim($c->name) != '')->filter(fn($c)=>optional($c->news)->sentiment=='Positive')->count() }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Negative News</p>
        <h2 class="text-3xl font-bold text-red-600">
            {{ $countries->filter(fn($c) => !empty($c->name) && $c->name != '-' && trim($c->name) != '')->filter(fn($c)=>optional($c->news)->sentiment=='Negative')->count() }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Updated</p>
        <h2 class="text-2xl font-bold text-blue-600">
            Today
        </h2>
    </div>

</div>

<div class="bg-white rounded-xl shadow p-6">

<table class="table-auto w-full border">

<thead class="bg-gray-200">

<tr>

<th class="border p-3">Country</th>

<th class="border p-3">Headline</th>

<th class="border p-3">Sentiment</th>

<th class="border p-3">News Score</th>

</tr>

</thead>

<tbody>

@foreach($countries as $country)
    {{-- VALIDASI: Skip baris jika nama negara kosong atau hanya strip --}}
    @if(empty($country->name) || $country->name == '-' || trim($country->name) == '')
        @continue
    @endif

<tr class="hover:bg-gray-100">

<td class="border p-3">
{{ $country->name }}
</td>

<td class="border p-3">
{{ optional($country->news)->title }}
</td>

<td class="border p-3">

@if(optional($country->news)->sentiment=='Positive')

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
Positive
</span>

@elseif(optional($country->news)->sentiment=='Negative')

<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
Negative
</span>

@else

<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
Neutral
</span>

@endif

</td>

<td class="border p-3 font-bold">
{{ optional($country->news)->news_score }}
</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection