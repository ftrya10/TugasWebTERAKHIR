@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Country Comparison Engine
</h1>

{{-- Form Selector 2 Negara --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <form action="{{ route('compare') }}" method="GET" class="grid grid-cols-12 gap-4 items-center">
        
        <div class="col-span-5">
            <label class="block text-gray-700 font-bold mb-2">Select Country A</label>
            <select name="country_a" class="w-full border rounded-lg px-4 py-2 bg-white shadow-sm">
                @foreach($countries as $c)
                    <option value="{{ $c->id }}" {{ optional($countryA)->id == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-span-2 text-center font-bold text-xl text-gray-500 mt-6">
            VS
        </div>

        <div class="col-span-5">
            <label class="block text-gray-700 font-bold mb-2">Select Country B</label>
            <select name="country_b" class="w-full border rounded-lg px-4 py-2 bg-white shadow-sm">
                @foreach($countries as $c)
                    <option value="{{ $c->id }}" {{ optional($countryB)->id == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-span-12 text-center mt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-lg font-bold shadow">
                Compare Now
            </button>
        </div>

    </form>
</div>

{{-- Tabel Comparison Side-by-Side --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="p-4 text-center text-xl font-bold text-blue-600 w-1/3">
                    {{ optional($countryA)->name }}
                </th>
                <th class="p-4 text-center text-lg font-bold text-gray-500 w-1/3">
                    Indicator
                </th>
                <th class="p-4 text-center text-xl font-bold text-blue-600 w-1/3">
                    {{ optional($countryB)->name }}
                </th>
            </tr>
        </thead>
        <tbody class="divide-y text-center">

            <!-- GDP -->
            <tr class="hover:bg-gray-50">
                <td class="p-4 font-semibold text-lg">
                    ${{ number_format(optional($countryA)->gdp / 1e12, 1) }} Trillion
                </td>
                <td class="p-4 font-bold text-gray-500 bg-gray-50">GDP</td>
                <td class="p-4 font-semibold text-lg">
                    ${{ number_format(optional($countryB)->gdp / 1e12, 1) }} Trillion
                </td>
            </tr>

            <!-- Inflation -->
            <tr class="hover:bg-gray-50">
                <td class="p-4 font-semibold text-lg">{{ optional($countryA)->inflation }}%</td>
                <td class="p-4 font-bold text-gray-500 bg-gray-50">Inflation</td>
                <td class="p-4 font-semibold text-lg">{{ optional($countryB)->inflation }}%</td>
            </tr>

            <!-- Population -->
            <tr class="hover:bg-gray-50">
                <td class="p-4 font-semibold text-lg">
                    {{ number_format(optional($countryA)->population / 1e6, 0) }} Million
                </td>
                <td class="p-4 font-bold text-gray-500 bg-gray-50">Population</td>
                <td class="p-4 font-semibold text-lg">
                    {{ number_format(optional($countryB)->population / 1e6, 0) }} Million
                </td>
            </tr>

            <!-- Currency -->
            <tr class="hover:bg-gray-50">
                <td class="p-4 font-semibold text-lg">{{ optional($countryA)->currency }}</td>
                <td class="p-4 font-bold text-gray-500 bg-gray-50">Currency</td>
                <td class="p-4 font-semibold text-lg">{{ optional($countryB)->currency }}</td>
            </tr>

            <!-- Weather -->
            <tr class="hover:bg-gray-50">
                <td class="p-4 font-semibold text-lg">
                    {{ optional(optional($countryA)->weather)->temp ?? 20 }}°C 
                    ({{ optional(optional($countryA)->weather)->condition ?? 'Clear' }})
                </td>
                <td class="p-4 font-bold text-gray-500 bg-gray-50">Weather</td>
                <td class="p-4 font-semibold text-lg">
                    {{ optional(optional($countryB)->weather)->temp ?? 20 }}°C 
                    ({{ optional(optional($countryB)->weather)->condition ?? 'Clear' }})
                </td>
            </tr>

            <!-- Risk Score -->
            <tr class="hover:bg-gray-50">
                <td class="p-4 font-bold text-xl text-red-600">
                    {{ optional(optional($countryA)->riskScore)->total_score }}
                </td>
                <td class="p-4 font-bold text-gray-500 bg-gray-50">Risk Score</td>
                <td class="p-4 font-bold text-xl text-red-600">
                    {{ optional(optional($countryB)->riskScore)->total_score }}
                </td>
            </tr>

            <!-- Risk Status -->
            <tr class="hover:bg-gray-50">
                <td class="p-4">
                    <span class="px-4 py-1 rounded-full font-bold text-sm bg-blue-100 text-blue-700">
                        {{ optional(optional($countryA)->riskScore)->status }}
                    </span>
                </td>
                <td class="p-4 font-bold text-gray-500 bg-gray-50">Risk Status</td>
                <td class="p-4">
                    <span class="px-4 py-1 rounded-full font-bold text-sm bg-blue-100 text-blue-700">
                        {{ optional(optional($countryB)->riskScore)->status }}
                    </span>
                </td>
            </tr>

        </tbody>
    </table>
</div>

@endsection