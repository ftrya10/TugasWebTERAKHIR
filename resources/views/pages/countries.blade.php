@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Countries
</h1>

<div class="bg-white rounded-xl shadow p-6">

    <table class="table-auto w-full border-collapse">

        <thead class="bg-gray-100">
            <tr>
                <th class="border p-3">Country</th>
                <th class="border p-3">GDP</th>
                <th class="border p-3">Inflation</th>
                <th class="border p-3">Population</th>
                <th class="border p-3">Currency</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="border p-3">Germany</td>
                <td class="border p-3">$4.7T</td>
                <td class="border p-3">2.4%</td>
                <td class="border p-3">84 Million</td>
                <td class="border p-3">EUR</td>
            </tr>

            <tr>
                <td class="border p-3">China</td>
                <td class="border p-3">$18T</td>
                <td class="border p-3">0.7%</td>
                <td class="border p-3">1.4 Billion</td>
                <td class="border p-3">CNY</td>
            </tr>

            <tr>
                <td class="border p-3">Indonesia</td>
                <td class="border p-3">$1.5T</td>
                <td class="border p-3">3.2%</td>
                <td class="border p-3">280 Million</td>
                <td class="border p-3">IDR</td>
            </tr>

            <tr>
                <td class="border p-3">Australia</td>
                <td class="border p-3">$1.8T</td>
                <td class="border p-3">2.9%</td>
                <td class="border p-3">27 Million</td>
                <td class="border p-3">AUD</td>
            </tr>
        </tbody>

    </table>

</div>

@endsection