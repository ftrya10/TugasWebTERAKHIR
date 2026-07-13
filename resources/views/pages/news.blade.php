@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Global News
</h1>

{{-- Summary Cards --}}
<div class="grid grid-cols-4 gap-6 mb-6">

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Total News</p>
        <h2 class="text-3xl font-bold">4</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Positive News</p>
        <h2 class="text-3xl font-bold text-green-600">2</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Neutral News</p>
        <h2 class="text-3xl font-bold text-yellow-600">1</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Negative News</p>
        <h2 class="text-3xl font-bold text-red-600">1</h2>
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

<th class="border p-3">Headline</th>

<th class="border p-3">Source</th>

<th class="border p-3">Sentiment</th>

<th class="border p-3">News Score</th>

<th class="border p-3">Action</th>

</tr>

</thead>

<tbody>

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">Germany</td>

<td class="border p-3">
Germany Economy Shows Positive Growth
</td>

<td class="border p-3">
Reuters
</td>

<td class="border p-3">
<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
Positive
</span>
</td>

<td class="border p-3 font-bold">
10
</td>

<td class="border p-3">
<a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
View
</a>
</td>

</tr>

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">China</td>

<td class="border p-3">
China Manufacturing Remains Stable
</td>

<td class="border p-3">
Bloomberg
</td>

<td class="border p-3">
<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">
Neutral
</span>
</td>

<td class="border p-3 font-bold">
15
</td>

<td class="border p-3">
<a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
View
</a>
</td>

</tr>

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">Indonesia</td>

<td class="border p-3">
Export Activity Increased This Quarter
</td>

<td class="border p-3">
CNBC Indonesia
</td>

<td class="border p-3">
<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
Positive
</span>
</td>

<td class="border p-3 font-bold">
8
</td>

<td class="border p-3">
<a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
View
</a>
</td>

</tr>

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">Australia</td>

<td class="border p-3">
Storm Disrupts Major Shipping Routes
</td>

<td class="border p-3">
BBC News
</td>

<td class="border p-3">
<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
Negative
</span>
</td>

<td class="border p-3 font-bold">
22
</td>

<td class="border p-3">
<a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
View
</a>
</td>

</tr>

</tbody>

</table>

</div>

@endsection