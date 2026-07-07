@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Exchange Rate
</h1>

<div class="bg-white rounded-xl shadow p-6">

    <table class="table-auto w-full">

        <tr class="border-b">
            <td class="py-3 font-semibold">Country</td>
            <td>Germany</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Currency</td>
            <td>EUR</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Exchange Rate</td>
            <td>1 EUR = 1.08 USD</td>
        </tr>

        <tr>
            <td class="py-3 font-semibold">Exchange Score</td>
            <td>20</td>
        </tr>

    </table>

</div>

@endsection