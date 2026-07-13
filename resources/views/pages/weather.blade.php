@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Weather
</h1>

{{-- Summary Cards --}}
<div class="grid grid-cols-4 gap-6 mb-6">

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Current Country</p>
        <h2 class="text-2xl font-bold">Germany</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Temperature</p>
        <h2 class="text-2xl font-bold">18°C</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Condition</p>
        <h2 class="text-2xl font-bold">☁️ Cloudy</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Weather Score</p>
        <h2 class="text-2xl font-bold text-blue-600">10</h2>
    </div>

</div>

{{-- Search --}}
<div class="flex justify-end mb-4">

    <input
        type="text"
        placeholder="Search Country..."
        class="border rounded-lg px-4 py-2 w-64">

</div>

<div class="bg-white shadow rounded-xl p-6">

<table class="table-auto w-full border-collapse">

<thead class="bg-gray-200">

<tr>

<th class="border p-3">Country</th>

<th class="border p-3">Temperature</th>

<th class="border p-3">Condition</th>

<th class="border p-3">Weather Score</th>

<th class="border p-3">Status</th>

<th class="border p-3">Action</th>

</tr>

</thead>

<tbody>

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">Germany</td>

<td class="border p-3">18°C</td>

<td class="border p-3">☁️ Cloudy</td>

<td class="border p-3 font-bold">10</td>

<td class="border p-3">
    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
        Safe
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

<td class="border p-3 font-semibold">China</td>

<td class="border p-3">25°C</td>

<td class="border p-3">🌤 Sunny</td>

<td class="border p-3 font-bold">8</td>

<td class="border p-3">
    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
        Safe
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

<td class="border p-3 font-semibold">Indonesia</td>

<td class="border p-3">31°C</td>

<td class="border p-3">🌧 Rain</td>

<td class="border p-3 font-bold">18</td>

<td class="border p-3">
    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
        Warning
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

<td class="border p-3 font-semibold">Australia</td>

<td class="border p-3">15°C</td>

<td class="border p-3">⛈ Storm</td>

<td class="border p-3 font-bold">28</td>

<td class="border p-3">
    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
        Dangerous
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