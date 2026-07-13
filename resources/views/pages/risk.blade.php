@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Risk Analysis
</h1>

<div class="bg-white rounded-xl shadow p-6">

    <table class="table-auto w-full border">

        <thead class="bg-gray-200">

            <tr>
                <th class="border p-3">Country</th>
                <th class="border p-3">Weather Score</th>
                <th class="border p-3">Inflation Score</th>
                <th class="border p-3">Exchange Score</th>
                <th class="border p-3">News Score</th>
                <th class="border p-3">Total Score</th>
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
                    {{ optional($country->riskScore)->weather_score }}
                </td>

                <td class="border p-3">
                    {{ optional($country->riskScore)->inflation_score }}
                </td>

                <td class="border p-3">
                    {{ optional($country->riskScore)->exchange_score }}
                </td>

                <td class="border p-3">
                    {{ optional($country->riskScore)->news_score }}
                </td>

                <td class="border p-3 font-bold">
                    {{ optional($country->riskScore)->total_score }}
                </td>

                <td class="border p-3">

                    @php
                        $status = optional($country->riskScore)->status;
                    @endphp

                    @if($status == 'Low Risk')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold">
                            {{ $status }}
                        </span>

                    @elseif($status == 'Medium Risk')
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full font-semibold">
                            {{ $status }}
                        </span>

                    @elseif($status == 'High Risk')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full font-semibold">
                            {{ $status }}
                        </span>

                    @endif

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection