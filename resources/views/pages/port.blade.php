@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Port Map
</h1>

<div class="bg-white rounded-xl shadow p-6">

    <table class="table-auto w-full">

        <tr class="border-b">
            <td class="py-3 font-semibold">Port</td>
            <td>Hamburg Port</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Country</td>
            <td>Germany</td>
        </tr>

        <tr class="border-b">
            <td class="py-3 font-semibold">Status</td>
            <td>Operational</td>
        </tr>

        <tr>
            <td class="py-3 font-semibold">Description</td>
            <td>One of the busiest ports in Europe.</td>
        </tr>

    </table>

</div>

@endsection