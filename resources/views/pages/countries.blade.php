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

        @forelse($countries as $country)

            <tr>
                <td class="border p-3">{{ $country->name }}</td>
                <td class="border p-3">{{ $country->gdp }}</td>
                <td class="border p-3">{{ $country->inflation }}%</td>
                <td class="border p-3">{{ $country->population }}</td>
                <td class="border p-3">{{ $country->currency }}</td>
            </tr>

        @empty

            <tr>
                <td colspan="5" class="border p-3 text-center">
                    Tidak ada data negara.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection