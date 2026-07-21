@extends('layouts.app')

@section('title', 'Country Intelligence Center')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

```
{{-- HEADER --}}
<div>
    <div class="flex items-center gap-3">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-2xl shadow-lg">
            🌍
        </div>

        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                GlobalTrade Intelligence
            </h1>

            <p class="mt-1 text-gray-600 dark:text-gray-400">
                Country Intelligence Center
            </p>
        </div>
    </div>

    <p class="mt-4 max-w-3xl text-gray-600 dark:text-gray-400">
        Analisis profil ekonomi dan kondisi negara secara terintegrasi.
        Pilih negara untuk melihat GDP, inflasi, populasi, mata uang,
        dan kondisi cuaca terkini.
    </p>
</div>


{{-- COUNTRY SELECTOR --}}
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">

    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
            Select Country
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Pilih negara untuk membuka Country Intelligence Profile.
        </p>
    </div>

    <select
        id="countrySelector"
        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
    >
        <option value="">-- Pilih Negara --</option>

        @foreach($countries as $country)

            <option
                value="{{ $country->id }}"
                data-code="{{ $country->code }}"
                data-name="{{ $country->name }}"
                data-currency="{{ $country->currency ?? '-' }}"
                data-population="{{ $country->population ?? 0 }}"
                data-latitude="{{ $country->latitude ?? 0 }}"
                data-longitude="{{ $country->longitude ?? 0 }}"
                data-flag="{{ $country->flag ?? '' }}"
            >
                {{ $country->name }}
            </option>

        @endforeach

    </select>

</div>


{{-- EMPTY STATE --}}
<div
    id="emptyState"
    class="rounded-2xl border border-dashed border-gray-300 bg-white p-12 text-center shadow-sm dark:border-gray-700 dark:bg-gray-900"
>

    <div class="text-6xl">
        🌍
    </div>

    <h2 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">
        Select a Country
    </h2>

    <p class="mx-auto mt-2 max-w-md text-gray-500 dark:text-gray-400">
        Pilih negara di atas untuk membuka Country Intelligence Profile.
    </p>

</div>


{{-- LOADING --}}
<div
    id="loadingState"
    class="hidden rounded-2xl border border-gray-200 bg-white p-10 text-center shadow-sm dark:border-gray-700 dark:bg-gray-900"
>

    <div class="mx-auto h-10 w-10 animate-spin rounded-full border-4 border-gray-200 border-t-blue-600"></div>

    <p class="mt-4 text-gray-600 dark:text-gray-400">
        Mengambil data intelligence negara...
    </p>

</div>


{{-- COUNTRY INTELLIGENCE --}}
<div id="countryProfile" class="hidden space-y-6">

    {{-- COUNTRY HEADER --}}
    <div class="overflow-hidden rounded-2xl bg-gradient-to-r from-blue-700 to-indigo-700 p-6 text-white shadow-lg">

        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">

            <div class="flex items-center gap-5">

                <img
                    id="countryFlag"
                    src=""
                    alt="Country Flag"
                    class="hidden h-16 w-24 rounded-lg object-cover shadow-md"
                >

                <div>
                    <p class="text-sm font-medium text-blue-100">
                        Country Intelligence Profile
                    </p>

                    <h2
                        id="countryName"
                        class="mt-1 text-3xl font-bold"
                    >
                        -
                    </h2>

                    <p
                        id="countryCode"
                        class="mt-1 text-sm text-blue-100"
                    >
                        -
                    </p>
                </div>

            </div>

            <div class="rounded-xl bg-white/10 px-5 py-4 backdrop-blur">

                <p class="text-xs uppercase tracking-wider text-blue-100">
                    Data Year
                </p>

                <p
                    id="economicYear"
                    class="mt-1 text-xl font-bold"
                >
                    -
                </p>

            </div>

        </div>

    </div>


    {{-- KPI CARDS --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-5">

        {{-- GDP --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">

            <div class="flex items-center justify-between">

                <span class="text-2xl">
                    💰
                </span>

                <span class="text-xs font-medium uppercase text-gray-400">
                    Economy
                </span>

            </div>

            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                GDP
            </p>

            <p
                id="gdpValue"
                class="mt-1 text-xl font-bold text-gray-900 dark:text-white"
            >
                Loading...
            </p>

        </div>


        {{-- INFLATION --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">

            <div class="flex items-center justify-between">

                <span class="text-2xl">
                    📈
                </span>

                <span class="text-xs font-medium uppercase text-gray-400">
                    Economy
                </span>

            </div>

            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                Inflation
            </p>

            <p
                id="inflationValue"
                class="mt-1 text-xl font-bold text-gray-900 dark:text-white"
            >
                Loading...
            </p>

        </div>


        {{-- POPULATION --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">

            <div class="flex items-center justify-between">

                <span class="text-2xl">
                    👥
                </span>

                <span class="text-xs font-medium uppercase text-gray-400">
                    Demographic
                </span>

            </div>

            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                Population
            </p>

            <p
                id="populationValue"
                class="mt-1 text-xl font-bold text-gray-900 dark:text-white"
            >
                -
            </p>

        </div>


        {{-- CURRENCY --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">

            <div class="flex items-center justify-between">

                <span class="text-2xl">
                    💱
                </span>

                <span class="text-xs font-medium uppercase text-gray-400">
                    Currency
                </span>

            </div>

            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                Currency
            </p>

            <p
                id="currencyValue"
                class="mt-1 text-xl font-bold text-gray-900 dark:text-white"
            >
                -
            </p>

        </div>


        {{-- WEATHER --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">

            <div class="flex items-center justify-between">

                <span class="text-2xl">
                    🌦️
                </span>

                <span class="text-xs font-medium uppercase text-gray-400">
                    Live Weather
                </span>

            </div>

            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                Current Weather
            </p>

            <p
                id="weatherValue"
                class="mt-1 text-xl font-bold text-gray-900 dark:text-white"
            >
                Loading...
            </p>

        </div>

    </div>


    {{-- INTELLIGENCE DETAILS --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- ECONOMIC INTELLIGENCE --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/30">
                    📊
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">
                        Economic Intelligence
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        World Bank economic indicators
                    </p>
                </div>

            </div>

            <div class="mt-6 space-y-4">

                <div class="flex items-center justify-between border-b border-gray-100 pb-4 dark:border-gray-800">

                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        GDP
                    </span>

                    <span
                        id="detailGdp"
                        class="font-semibold text-gray-900 dark:text-white"
                    >
                        -
                    </span>

                </div>

                <div class="flex items-center justify-between border-b border-gray-100 pb-4 dark:border-gray-800">

                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Inflation
                    </span>

                    <span
                        id="detailInflation"
                        class="font-semibold text-gray-900 dark:text-white"
                    >
                        -
                    </span>

                </div>

                <div class="flex items-center justify-between">

                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Unemployment
                    </span>

                    <span
                        id="detailUnemployment"
                        class="font-semibold text-gray-900 dark:text-white"
                    >
                        -
                    </span>

                </div>

            </div>

        </div>


        {{-- WEATHER INTELLIGENCE --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-100 dark:bg-cyan-900/30">
                    🌦️
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">
                        Weather Intelligence
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Current conditions affecting supply chains
                    </p>
                </div>

            </div>

            <div class="mt-6 space-y-4">

                <div class="flex items-center justify-between border-b border-gray-100 pb-4 dark:border-gray-800">

                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Condition
                    </span>

                    <span
                        id="detailWeather"
                        class="font-semibold text-gray-900 dark:text-white"
                    >
                        -
                    </span>

                </div>

                <div class="flex items-center justify-between border-b border-gray-100 pb-4 dark:border-gray-800">

                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Temperature
                    </span>

                    <span
                        id="detailTemperature"
                        class="font-semibold text-gray-900 dark:text-white"
                    >
                        -
                    </span>

                </div>

                <div class="flex items-center justify-between">

                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Risk Score
                    </span>

                    <span
                        id="detailWeatherScore"
                        class="font-semibold text-gray-900 dark:text-white"
                    >
                        -
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>
```

</div>

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const selector = document.getElementById('countrySelector');

    const emptyState = document.getElementById('emptyState');

    const loadingState = document.getElementById('loadingState');

    const countryProfile = document.getElementById('countryProfile');


    selector.addEventListener('change', async function () {

        const selectedOption =
            selector.options[selector.selectedIndex];


        if (!selectedOption.value) {

            countryProfile.classList.add('hidden');

            loadingState.classList.add('hidden');

            emptyState.classList.remove('hidden');

            return;

        }


        const countryId =
            selectedOption.value;

        const countryCode =
            selectedOption.dataset.code;

        const countryName =
            selectedOption.dataset.name;

        const currency =
            selectedOption.dataset.currency || '-';

        const population =
            Number(selectedOption.dataset.population || 0);

        const latitude =
            selectedOption.dataset.latitude;

        const longitude =
            selectedOption.dataset.longitude;

        const flag =
            selectedOption.dataset.flag;


        emptyState.classList.add('hidden');

        countryProfile.classList.add('hidden');

        loadingState.classList.remove('hidden');


        // Basic Country Data

        document.getElementById('countryName').textContent =
            countryName;

        document.getElementById('countryCode').textContent =
            countryCode;

        document.getElementById('currencyValue').textContent =
            currency;

        document.getElementById('populationValue').textContent =
            population.toLocaleString('en-US');


        document.getElementById('countryFlag').src =
            flag;

        if (flag) {
            document.getElementById('countryFlag')
                .classList.remove('hidden');
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | ECONOMIC DATA
            |--------------------------------------------------------------------------
            */

            const economicResponse =
                await fetch(
                    `/countries/api/economic/${countryCode}`
                );

            const economicJson =
                await economicResponse.json();


            if (
                economicJson.status === 'success' &&
                economicJson.data
            ) {

                const data =
                    economicJson.data;


                const gdp =
                    data.gdp !== null
                        ? '$' + Number(data.gdp).toLocaleString('en-US', {
                            maximumFractionDigits: 0
                        })
                        : 'N/A';


                const inflation =
                    data.inflation !== null
                        ? Number(data.inflation).toFixed(2) + '%'
                        : 'N/A';


                const unemployment =
                    data.unemployment !== null
                        ? Number(data.unemployment).toFixed(2) + '%'
                        : 'N/A';


                document.getElementById('gdpValue')
                    .textContent = gdp;

                document.getElementById('inflationValue')
                    .textContent = inflation;

                document.getElementById('detailGdp')
                    .textContent = gdp;

                document.getElementById('detailInflation')
                    .textContent = inflation;

                document.getElementById('detailUnemployment')
                    .textContent = unemployment;

                document.getElementById('economicYear')
                    .textContent = economicJson.year || '-';

            }


            /*
            |--------------------------------------------------------------------------
            | WEATHER DATA
            |--------------------------------------------------------------------------
            */

            if (latitude && longitude) {

                const weatherResponse =
                    await fetch(
                        `/weather/api/${latitude}/${longitude}`
                    );

                const weatherJson =
                    await weatherResponse.json();


                if (
                    weatherJson.status === 'success' &&
                    weatherJson.data
                ) {

                    const weather =
                        weatherJson.data;


                    const condition =
                        weather.condition ||
                        weather.description ||
                        'Unknown';


                    const temperature =
                        weather.temperature !== undefined
                            ? weather.temperature + '°C'
                            : 'N/A';


                    document.getElementById('weatherValue')
                        .textContent = condition;


                    document.getElementById('detailWeather')
                        .textContent = condition;


                    document.getElementById('detailTemperature')
                        .textContent = temperature;


                    document.getElementById('detailWeatherScore')
                        .textContent =
                            weather.weather_score ?? '-';

                } else {

                    document.getElementById('weatherValue')
                        .textContent = 'Unavailable';

                }

            }


            countryProfile.classList.remove('hidden');

        } catch (error) {

            console.error(
                'Country Intelligence Error:',
                error
            );

            alert(
                'Gagal mengambil data Country Intelligence.'
            );

        } finally {

            loadingState.classList.add('hidden');

        }

    });

});

</script>

@endpush

@endsection
