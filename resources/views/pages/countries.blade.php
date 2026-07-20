@extends('layouts.app')

@section('content')

<div class="container mx-auto">

    <h1 class="text-4xl font-bold mb-6">
        Countries
    </h1>


    {{-- Search --}}
    <div class="flex justify-between items-center mb-5">

        <form action="{{ route('countries.index') }}" method="GET">

            <input 
                type="text" 
                name="search"
                value="{{ request('search') }}"
                placeholder="Search Country..."
                class="border rounded-lg px-4 py-2 w-80"
            >

            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                Search
            </button>

        </form>


        <div class="font-semibold">
            Total Countries : {{ $countries->count() }}
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


            @forelse($countries as $country)


                <tr>


                    <td class="border p-3 text-3xl">

                        {{ $country->flag ?? '🌎' }}

                    </td>



                    <td class="border p-3">

                        {{ $country->name ?? '-' }}

                    </td>



                    <td class="border p-3">

                        @if($country->gdp)

                            ${{ number_format((float)$country->gdp, 1) }}

                        @else

                            -

                        @endif

                    </td>



                    <td class="border p-3">

                        {{ $country->inflation !== null 
                            ? $country->inflation.'%' 
                            : '-' }}

                    </td>



                    <td class="border p-3">

                        @if($country->population)

                            {{ number_format((int)$country->population) }}

                        @else

                            -

                        @endif

                    </td>



                    <td class="border p-3">

                        {{ $country->currency ?? '-' }}

                    </td>



                    <td class="border p-3">


                        <a href="{{ route('dashboard', ['country_id'=>$country->id]) }}"
                           class="bg-green-600 text-white px-3 py-2 rounded">

                            View Detail

                        </a>


                    </td>


                </tr>



            @empty


                <tr>

                    <td colspan="7" class="border p-3 text-center text-gray-500">

                        No countries found.

                    </td>

                </tr>


            @endforelse



            </tbody>


        </table>


    </div>


</div>


@endsection