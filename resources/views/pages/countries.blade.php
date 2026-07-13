@extends('layouts.app')

@section('content')

<div class="container mx-auto">

    <h1 class="text-4xl font-bold mb-6">
        Countries
    </h1>

    {{-- Search --}}
    <div class="flex justify-between items-center mb-5">

        <form action="{{ route('countries') }}" method="GET">

            <input
                type="text"
                name="search"
                placeholder="Search Country..."
                class="border rounded-lg px-4 py-2 w-80"
            >

            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                Search
            </button>

        </form>

        <div class="font-semibold">
            Total Countries : 4
        </div>

    </div>

    <div class="bg-white shadow rounded-xl p-6">

        <table class="w-full border">

            <thead class="bg-gray-100">

            <tr>

                <th class="border p-3">Flag</th>

                <th class="border p-3">Country</th>

                <th class="border p-3">GDP</th>

                <th class="border p-3">Inflation</th>

                <th class="border p-3">Population</th>

                <th class="border p-3">Currency</th>

                <th class="border p-3">Action</th>

            </tr>

            </thead>

            <tbody>

            <tr>

                <td class="border p-3 text-3xl">🇩🇪</td>

                <td class="border p-3">Germany</td>

                <td class="border p-3">$4.7 Trillion</td>

                <td class="border p-3">2.40%</td>

                <td class="border p-3">84 Million</td>

                <td class="border p-3">EUR</td>

                <td class="border p-3">

                    <a href="{{ route('dashboard',['country'=>'Germany']) }}"
                       class="bg-green-600 text-white px-3 py-2 rounded">
                        View Detail
                    </a>

                </td>

            </tr>

            <tr>

                <td class="border p-3 text-3xl">🇨🇳</td>

                <td class="border p-3">China</td>

                <td class="border p-3">$18 Trillion</td>

                <td class="border p-3">0.70%</td>

                <td class="border p-3">1.4 Billion</td>

                <td class="border p-3">CNY</td>

                <td class="border p-3">

                    <a href="{{ route('dashboard',['country'=>'China']) }}"
                       class="bg-green-600 text-white px-3 py-2 rounded">
                        View Detail
                    </a>

                </td>

            </tr>

            <tr>

                <td class="border p-3 text-3xl">🇮🇩</td>

                <td class="border p-3">Indonesia</td>

                <td class="border p-3">$1.5 Trillion</td>

                <td class="border p-3">3.20%</td>

                <td class="border p-3">280 Million</td>

                <td class="border p-3">IDR</td>

                <td class="border p-3">

                    <a href="{{ route('dashboard',['country'=>'Indonesia']) }}"
                       class="bg-green-600 text-white px-3 py-2 rounded">
                        View Detail
                    </a>

                </td>

            </tr>

            <tr>

                <td class="border p-3 text-3xl">🇦🇺</td>

                <td class="border p-3">Australia</td>

                <td class="border p-3">$1.8 Trillion</td>

                <td class="border p-3">2.90%</td>

                <td class="border p-3">27 Million</td>

                <td class="border p-3">AUD</td>

                <td class="border p-3">

                    <a href="{{ route('dashboard',['country'=>'Australia']) }}"
                       class="bg-green-600 text-white px-3 py-2 rounded">
                        View Detail
                    </a>

                </td>

            </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection