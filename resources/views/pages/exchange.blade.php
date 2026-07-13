@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Exchange Rate
</h1>

{{-- Summary Cards --}}
<div class="grid grid-cols-4 gap-6 mb-6">

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Currencies</p>
        <h2 class="text-3xl font-bold">4</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Highest Rate</p>
        <h2 class="text-2xl font-bold">EUR</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Lowest Rate</p>
        <h2 class="text-2xl font-bold">IDR</h2>
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

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">
🇩🇪 Germany
</td>

<td class="border p-3">
EUR
</td>

<td class="border p-3">
1 EUR = 1.08 USD
</td>

<td class="border p-3 font-bold">
20
</td>

<td class="border p-3">
<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
Stable
</span>
</td>

<td class="border p-3">
<a href="#"
class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
View
</a>
</td>

</tr>

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">
🇨🇳 China
</td>

<td class="border p-3">
CNY
</td>

<td class="border p-3">
1 CNY = 0.14 USD
</td>

<td class="border p-3 font-bold">
15
</td>

<td class="border p-3">
<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">
Moderate
</span>
</td>

<td class="border p-3">
<a href="#"
class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
View
</a>
</td>

</tr>

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">
🇮🇩 Indonesia
</td>

<td class="border p-3">
IDR
</td>

<td class="border p-3">
1 USD = 16,250 IDR
</td>

<td class="border p-3 font-bold">
28
</td>

<td class="border p-3">
<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
Volatile
</span>
</td>

<td class="border p-3">
<a href="#"
class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
View
</a>
</td>

</tr>

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">
🇦🇺 Australia
</td>

<td class="border p-3">
AUD
</td>

<td class="border p-3">
1 AUD = 0.67 USD
</td>

<td class="border p-3 font-bold">
18
</td>

<td class="border p-3">
<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
Stable
</span>
</td>

<td class="border p-3">
<a href="#"
class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
View
</a>
</td>

</tr>

</tbody>

</table>

</div>

@endsection