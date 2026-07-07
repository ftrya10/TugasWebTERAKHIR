@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Weather
</h1>

<div class="bg-white shadow rounded-xl p-6">

    <table class="table-auto w-full">

        <tr class="border-b">
            <td class="py-3 font-semibold">Country</td>
            <td>Germany</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Temperature</td>
            <td>18°C</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Condition</td>
            <td>Cloudy</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Weather Score</td>
            <td>10</td>
        </tr>

    </table>

</div>

@endsection