@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Risk Analysis
</h1>

<div class="bg-white rounded-xl shadow p-6">

    <table class="table-auto w-full">

        <tr class="border-b">
            <td class="py-3 font-semibold">Country</td>
            <td>Germany</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Weather Score</td>
            <td>10</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Inflation Score</td>
            <td>15</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Exchange Score</td>
            <td>20</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">News Score</td>
            <td>10</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Total Risk Score</td>
            <td>55</td>
        </tr>

        <tr>
            <td class="py-3 font-semibold">Status</td>
            <td class="text-green-600 font-bold">Low Risk</td>
        </tr>

    </table>

</div>

@endsection