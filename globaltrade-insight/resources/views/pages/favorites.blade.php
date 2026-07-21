@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Favorites
</h1>

{{-- Summary Cards --}}
<div class="grid grid-cols-3 gap-6 mb-6">

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Favorite Countries</p>
        <h2 class="text-3xl font-bold">2</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Low Risk</p>
        <h2 class="text-3xl font-bold text-green-600">1</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500">Medium Risk</p>
        <h2 class="text-3xl font-bold text-yellow-600">1</h2>
    </div>

</div>

{{-- Search --}}
<div class="flex justify-end mb-4">

    <input
        type="text"
        placeholder="Search Favorite..."
        class="border rounded-lg px-4 py-2 w-64">

</div>

<div class="bg-white rounded-xl shadow p-6">

<table class="table-auto w-full border-collapse">

<thead class="bg-gray-200">

<tr>

<th class="border p-3">Country</th>

<th class="border p-3">Currency</th>

<th class="border p-3">Risk Status</th>

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

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
Low Risk
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

<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">
Medium Risk
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