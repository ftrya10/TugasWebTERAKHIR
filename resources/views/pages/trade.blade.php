@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
Trade Analysis
</h1>

<div class="bg-white rounded-xl shadow p-6">

<table class="table-auto w-full border">

<thead class="bg-gray-200">

<tr>

<th class="border p-3">Country</th>

<th class="border p-3">GDP</th>

<th class="border p-3">Inflation</th>

<th class="border p-3">Risk Score</th>

<th class="border p-3">Status</th>

</tr>

</thead>

<tbody>

@foreach($countries as $country)

<tr>

<td class="border p-3">
{{ $country->name }}
</td>

<td class="border p-3">
{{ $country->gdp }}
</td>

<td class="border p-3">
{{ $country->inflation }}
</td>

<td class="border p-3">
{{ optional($country->riskScore)->total_score }}
</td>

<td class="border p-3">
{{ optional($country->riskScore)->status }}
</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection