@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Favorites
</h1>

<div class="bg-white rounded-xl shadow p-6">

    <h2 class="text-xl font-semibold mb-4">
        Favorite Countries
    </h2>

    <table class="table-auto w-full border-collapse">

        <thead>
            <tr class="bg-gray-100">
                <th class="border p-3 text-left">Country</th>
                <th class="border p-3 text-left">Currency</th>
                <th class="border p-3 text-left">Risk Status</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="border p-3">Germany</td>
                <td class="border p-3">EUR</td>
                <td class="border p-3 text-green-600 font-bold">Low Risk</td>
            </tr>

            <tr>
                <td class="border p-3">Indonesia</td>
                <td class="border p-3">IDR</td>
                <td class="border p-3 text-yellow-600 font-bold">Medium Risk</td>
            </tr>
        </tbody>

    </table>

</div>

@endsection