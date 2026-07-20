@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Trade Analysis
</h1>

{{-- Summary Cards --}}
<div class="grid grid-cols-4 gap-6 mb-6">

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Total Countries</p>
        <h2 class="text-3xl font-bold">
            {{ $countries->count() }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Highest GDP</p>
        <h2 class="text-2xl font-bold">
            China
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Highest Risk</p>
        <h2 class="text-2xl font-bold text-red-600">
            Indonesia
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Average Inflation</p>
        <h2 class="text-2xl font-bold">
            2.3%
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

<th class="border p-3">GDP</th>

<th class="border p-3">Inflation</th>

<th class="border p-3">Currency</th>

<th class="border p-3">Risk Score</th>

<th class="border p-3">Status</th>

<th class="border p-3">Action</th>

</tr>

</thead>

<tbody>

@foreach($countries as $country)

    @if(empty($country->name) || $country->name == '-' || trim($country->name) == '')
        @continue
    @endif

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">
    {{ $country->name }}
</td>

<td class="border p-3">
    {{ $country->gdp }}
</td>

<td class="border p-3">
    {{ $country->inflation }}%
</td>

<td class="border p-3">
    {{ $country->currency }}
</td>

<td class="border p-3 font-bold">
    {{ optional($country->riskScore)->total_score ?? '-' }}
</td>

<td class="border p-3">

@if(optional($country->riskScore)->status == 'Low Risk')
    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
        Low Risk
    </span>
@elseif(optional($country->riskScore)->status == 'Medium Risk')
    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
        Medium Risk
    </span>
@elseif(optional($country->riskScore)->status == 'High Risk')
    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
        High Risk
    </span>
@else
    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
        -
    </span>
@endif

</td>

<td class="border p-3">

<a href="{{ route('dashboard', ['country' => $country->id]) }}"
   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
    View
</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection