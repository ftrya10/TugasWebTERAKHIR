```blade
@extends('layouts.app')

@section('title', 'Country Intelligence Center')

@section('content')

<div class="min-h-screen bg-slate-50 dark:bg-slate-950 p-6">

    <div class="max-w-7xl mx-auto">

        {{-- HEADER --}}
        <div class="mb-8">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                <div class="flex items-center gap-4">

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-white text-3xl shadow-lg">
                        🌍
                    </div>

                    <div>

                        <h1 class="text-3xl font-black text-slate-900 dark:text-white">
                            Country Intelligence Center
                        </h1>

                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            Pilih negara untuk melihat indikator ekonomi, populasi,
                            mata uang, cuaca, risiko, dan informasi intelijen negara.
                        </p>

                    </div>

                </div>

                <div class="rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 px-4 py-3">

                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-400">
                        Monitored Countries
                    </p>

                    <p class="text-xl font-black text-blue-600">
                        {{ $countries->count() }}
                    </p>

                </div>

            </div>

        </div>


        {{-- COUNTRY SELECTOR --}}
        <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                    bg-white dark:bg-slate-900 p-6 shadow-sm">

            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">
                Pilih Negara
            </label>

            <select
                id="countrySelect"
                class="w-full rounded-xl border border-slate-300 dark:border-slate-700
                       bg-white dark:bg-slate-800
                       px-4 py-3 text-sm font-semibold
                       text-slate-900 dark:text-white
                       focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
            >

                <option value="">
                    -- Pilih Negara --
                </option>

                @foreach($countries as $country)

                    <option value="{{ route('countries.show', $country->id) }}">

                        {{ $country->name }}

                        @if($country->code)
                            ({{ strtoupper($country->code) }})
                        @endif

                    </option>

                @endforeach

            </select>

        </div>


        {{-- EMPTY STATE --}}
        <div
            id="emptyState"
            class="mt-6 rounded-2xl border border-slate-200 dark:border-slate-800
                   bg-white dark:bg-slate-900 p-12 text-center shadow-sm"
        >

            <div class="text-6xl mb-4">
                🌍
            </div>

            <h2 class="text-xl font-black text-slate-900 dark:text-white">
                Select a Country
            </h2>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Pilih negara di atas untuk membuka
                Country Intelligence Profile.
            </p>

        </div>


        {{-- COUNTRY LIST --}}
        <div class="mt-8">

            <div class="flex items-center justify-between mb-5">

                <div>

                    <h2 class="text-xl font-black text-slate-900 dark:text-white">
                        Monitored Countries
                    </h2>

                    <p class="text-xs text-slate-500 mt-1">
                        Data ekonomi diperbarui berdasarkan sumber World Bank.
                    </p>

                </div>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                @foreach($countries as $country)

                    <div
                        class="country-card rounded-2xl border border-slate-200
                               dark:border-slate-800
                               bg-white dark:bg-slate-900
                               shadow-sm hover:shadow-xl
                               hover:-translate-y-1
                               transition overflow-hidden"
                    >

                        {{-- CARD HEADER --}}
                        <div class="p-5 border-b border-slate-100 dark:border-slate-800">

                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-12 w-12 items-center justify-center
                                                rounded-xl bg-blue-50 dark:bg-blue-950/40
                                                text-2xl">
                                        🌍
                                    </div>

                                    <div>

                                        <h3 class="font-black text-slate-900 dark:text-white">

                                            {{ $country->name }}

                                        </h3>

                                        <p class="text-[10px] uppercase font-bold text-slate-400">

                                            {{ strtoupper($country->code) }}

                                        </p>

                                    </div>

                                </div>

                                <span class="text-xs font-bold text-slate-400">

                                    {{ strtoupper($country->code) }}

                                </span>

                            </div>

                        </div>


                        {{-- ECONOMIC DATA --}}
                        <div
                            class="economic-data p-5"
                            data-code="{{ strtoupper($country->code) }}"
                        >

                            {{-- LOADING --}}
                            <div class="economic-loading">

                                <div class="grid grid-cols-2 gap-3">

                                    @for($i = 0; $i < 6; $i++)

                                        <div class="rounded-xl bg-slate-100 dark:bg-slate-800 p-3 animate-pulse">

                                            <div class="h-2 w-16 bg-slate-200 dark:bg-slate-700 rounded mb-2"></div>

                                            <div class="h-4 w-20 bg-slate-200 dark:bg-slate-700 rounded"></div>

                                        </div>

                                    @endfor

                                </div>

                            </div>


                            {{-- DATA --}}
                            <div class="economic-content hidden">

                                <div class="grid grid-cols-2 gap-3">

                                    <div class="rounded-xl bg-blue-50 dark:bg-blue-950/30 p-3">

                                        <p class="text-[9px] uppercase font-black text-blue-500">
                                            GDP
                                        </p>

                                        <p class="gdp-value mt-1 text-sm font-black text-slate-900 dark:text-white">
                                            -
                                        </p>

                                    </div>


                                    <div class="rounded-xl bg-purple-50 dark:bg-purple-950/30 p-3">

                                        <p class="text-[9px] uppercase font-black text-purple-500">
                                            GDP Per Capita
                                        </p>

                                        <p class="gdp-capita-value mt-1 text-sm font-black text-slate-900 dark:text-white">
                                            -
                                        </p>

                                    </div>


                                    <div class="rounded-xl bg-emerald-50 dark:bg-emerald-950/30 p-3">

                                        <p class="text-[9px] uppercase font-black text-emerald-500">
                                            Population
                                        </p>

                                        <p class="population-value mt-1 text-sm font-black text-slate-900 dark:text-white">
                                            -
                                        </p>

                                    </div>


                                    <div class="rounded-xl bg-yellow-50 dark:bg-yellow-950/30 p-3">

                                        <p class="text-[9px] uppercase font-black text-yellow-600">
                                            Inflation
                                        </p>

                                        <p class="inflation-value mt-1 text-sm font-black text-slate-900 dark:text-white">
                                            -
                                        </p>

                                    </div>


                                    <div class="rounded-xl bg-orange-50 dark:bg-orange-950/30 p-3">

                                        <p class="text-[9px] uppercase font-black text-orange-600">
                                            Unemployment
                                        </p>

                                        <p class="unemployment-value mt-1 text-sm font-black text-slate-900 dark:text-white">
                                            -
                                        </p>

                                    </div>


                                    <div class="rounded-xl bg-slate-100 dark:bg-slate-800 p-3">

                                        <p class="text-[9px] uppercase font-black text-slate-500">
                                            Data Year
                                        </p>

                                        <p class="year-value mt-1 text-sm font-black text-slate-900 dark:text-white">
                                            -
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- ERROR --}}
                            <div class="economic-error hidden">

                                <div class="rounded-xl bg-red-50 dark:bg-red-950/20 p-4">

                                    <p class="text-xs font-bold text-red-600">
                                        Economic data unavailable
                                    </p>

                                    <p class="text-[10px] text-red-500 mt-1">
                                        Tidak dapat mengambil data World Bank.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- FOOTER --}}
                        <div class="px-5 pb-5">

                            <a
                                href="{{ route('countries.show', $country->id) }}"
                                class="block w-full text-center rounded-xl
                                       bg-slate-900 dark:bg-white
                                       px-4 py-3
                                       text-xs font-black
                                       text-white dark:text-slate-900
                                       hover:opacity-90 transition"
                            >
                                Open Intelligence Profile →
                            </a>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | COUNTRY SELECTOR
    |--------------------------------------------------------------------------
    */

    const select =
        document.getElementById('countrySelect');

    if (select) {

        select.addEventListener('change', function () {

            if (this.value) {

                window.location.href =
                    this.value;

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | LOAD WORLD BANK DATA
    |--------------------------------------------------------------------------
    */

    const cards =
        document.querySelectorAll(
            '.economic-data'
        );


    cards.forEach(function (card) {

        const code =
            card.dataset.code;

        if (!code) {
            return;
        }


        const loading =
            card.querySelector(
                '.economic-loading'
            );

        const content =
            card.querySelector(
                '.economic-content'
            );

        const error =
            card.querySelector(
                '.economic-error'
            );


        fetch(
            `/countries/api/economic/${code}`
        )

        .then(function (response) {

            if (!response.ok) {

                throw new Error(
                    'API Error'
                );

            }

            return response.json();

        })

        .then(function (result) {

            if (
                result.status !==
                'success'
            ) {

                throw new Error(
                    'Invalid API response'
                );

            }


            const data =
                result.data;


            /*
            |--------------------------------------------------------------------------
            | GDP
            |--------------------------------------------------------------------------
            */

            const gdp =
                data.gdp?.value;

            card.querySelector(
                '.gdp-value'
            ).textContent =

                gdp !== null &&
                gdp !== undefined

                    ? '$' +
                      (
                          Number(gdp)
                          / 1000000000
                      ).toFixed(2) +
                      'B'

                    : '-';


            /*
            |--------------------------------------------------------------------------
            | GDP PER CAPITA
            |--------------------------------------------------------------------------
            */

            const gdpCapita =
                data.gdp_per_capita?.value;

            card.querySelector(
                '.gdp-capita-value'
            ).textContent =

                gdpCapita !== null &&
                gdpCapita !== undefined

                    ? '$' +
                      Number(gdpCapita)
                      .toLocaleString(
                          'en-US',
                          {
                              maximumFractionDigits: 0
                          }
                      )

                    : '-';


            /*
            |--------------------------------------------------------------------------
            | POPULATION
            |--------------------------------------------------------------------------
            */

            const population =
                data.population?.value;

            card.querySelector(
                '.population-value'
            ).textContent =

                population !== null &&
                population !== undefined

                    ? Number(population)
                      .toLocaleString(
                          'en-US'
                      )

                    : '-';


            /*
            |--------------------------------------------------------------------------
            | INFLATION
            |--------------------------------------------------------------------------
            */

            const inflation =
                data.inflation?.value;

            card.querySelector(
                '.inflation-value'
            ).textContent =

                inflation !== null &&
                inflation !== undefined

                    ? Number(inflation)
                      .toFixed(2) +
                      '%'

                    : '-';


            /*
            |--------------------------------------------------------------------------
            | UNEMPLOYMENT
            |--------------------------------------------------------------------------
            */

            const unemployment =
                data.unemployment?.value;

            card.querySelector(
                '.unemployment-value'
            ).textContent =

                unemployment !== null &&
                unemployment !== undefined

                    ? Number(unemployment)
                      .toFixed(2) +
                      '%'

                    : '-';


            /*
            |--------------------------------------------------------------------------
            | YEAR
            |--------------------------------------------------------------------------
            */

            const years = [

                data.gdp?.year,

                data.gdp_per_capita?.year,

                data.population?.year,

                data.inflation?.year,

                data.unemployment?.year

            ].filter(Boolean);


            card.querySelector(
                '.year-value'
            ).textContent =

                years.length
                    ? Math.max(...years)
                    : '-';


            /*
            |--------------------------------------------------------------------------
            | SHOW DATA
            |--------------------------------------------------------------------------
            */

            loading.classList.add(
                'hidden'
            );

            content.classList.remove(
                'hidden'
            );

        })

        .catch(function (err) {

            console.error(
                'Economic data error:',
                code,
                err
            );

            loading.classList.add(
                'hidden'
            );

            error.classList.remove(
                'hidden'
            );

        });

    });

});

</script>

@endsection
```
