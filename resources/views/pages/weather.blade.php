@extends('layouts.app')

@section('content')

<div class="container mx-auto">

    <h1 class="text-4xl font-bold mb-6">
        Weather
    </h1>

    <div class="bg-white shadow rounded-xl p-6">

        <table class="w-full border">

            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-3">Country</th>
                    <th class="border p-3">Temperature</th>
                    <th class="border p-3">Condition</th>
                    <th class="border p-3">Score</th>
                </tr>
            </thead>

            <tbody>

            @forelse($weathers as $weather)

                <tr>
                    <td class="border p-3">
                        {{ $weather->country->name ?? '-' }}
                    </td>

                    <td class="border p-3">
                        {{ $weather->temperature ?? '-' }} °C
                    </td>

                    <td class="border p-3">
                        {{ $weather->condition ?? '-' }}
                    </td>

                    <td class="border p-3">
                        {{ $weather->weather_score ?? '-' }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4" class="text-center p-3">
                        No Weather Data
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection