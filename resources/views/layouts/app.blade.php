<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GlobalTrade Insight</title>


    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>


<body class="bg-gray-100">


<div class="flex min-h-screen">


    {{-- Sidebar --}}

    @include('partials.sidebar')



    {{-- Content Area --}}

    <div class="flex-1 flex flex-col">


        {{-- Navbar --}}

        @include('partials.navbar')



        {{-- Main Content --}}

        <main class="p-8 overflow-y-auto">


            @yield('content')


        </main>


    </div>


</div>


</body>

</html>