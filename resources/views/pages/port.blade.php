@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Port Map
</h1>

{{-- Summary Cards --}}
<div class="grid grid-cols-4 gap-6 mb-6">

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Total Ports</p>
        <h2 class="text-3xl font-bold">4</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Operational</p>
        <h2 class="text-3xl font-bold text-green-600">3</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Maintenance</p>
        <h2 class="text-3xl font-bold text-yellow-600">1</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Countries</p>
        <h2 class="text-3xl font-bold">4</h2>
    </div>

</div>

{{-- Search --}}
<div class="flex justify-end mb-4">

    <input
        type="text"
        placeholder="Search Port..."
        class="border rounded-lg px-4 py-2 w-64">

</div>

<div class="bg-white rounded-xl shadow p-6">

<table class="table-auto w-full border-collapse">

<thead class="bg-gray-200">

<tr>

<th class="border p-3">Port</th>

<th class="border p-3">Country</th>

<th class="border p-3">Status</th>

<th class="border p-3">Description</th>

<th class="border p-3">Action</th>

</tr>

</thead>

<tbody>

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">Hamburg Port</td>

<td class="border p-3">Germany</td>

<td class="border p-3">
<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
Operational
</span>
</td>

<td class="border p-3">
One of the busiest ports in Europe.
</td>

<td class="border p-3">
<a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
View
</a>
</td>

</tr>

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">Shanghai Port</td>

<td class="border p-3">China</td>

<td class="border p-3">
<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
Operational
</span>
</td>

<td class="border p-3">
Largest container port in the world.
</td>

<td class="border p-3">
<a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
View
</a>
</td>

</tr>

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">Tanjung Priok</td>

<td class="border p-3">Indonesia</td>

<td class="border p-3">
<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">
Maintenance
</span>
</td>

<td class="border p-3">
Main international port in Indonesia.
</td>

<td class="border p-3">
<a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
View
</a>
</td>

</tr>

<tr class="hover:bg-gray-100">

<td class="border p-3 font-semibold">Port of Sydney</td>

<td class="border p-3">Australia</td>

<td class="border p-3">
<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
Operational
</span>
</td>

<td class="border p-3">
Major commercial port in Australia.
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