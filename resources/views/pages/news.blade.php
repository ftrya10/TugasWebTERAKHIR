@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Global News
</h1>

<div class="bg-white rounded-xl shadow p-6">

    <table class="table-auto w-full">

        <tr class="border-b">
            <td class="py-3 font-semibold">Country</td>
            <td>Germany</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Headline</td>
            <td>Germany Economy Shows Positive Growth</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Source</td>
            <td>Reuters</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Sentiment</td>
            <td class="text-green-600 font-bold">Positive</td>
        </tr>

        <tr>
            <td class="py-3 font-semibold">News Score</td>
            <td>10</td>
        </tr>

    </table>

</div>

@endsection