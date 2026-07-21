<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GlobalTrade Insight</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen overflow-y-auto bg-slate-950">

    <!-- Background -->
    <div class="fixed inset-0 -z-10 overflow-hidden">

        <!-- Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900"></div>

        <!-- Glow -->
        <div class="absolute -top-32 -left-24 w-80 h-80 rounded-full bg-cyan-500/20 blur-[120px]"></div>

        <div class="absolute bottom-0 right-0 w-[450px] h-[450px] rounded-full bg-indigo-500/20 blur-[150px]"></div>

        <div class="absolute top-1/2 left-1/2 w-[350px] h-[350px] rounded-full bg-sky-500/10 blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>

        <!-- Decorative circles -->
        <div class="absolute top-20 right-24 w-2 h-2 bg-cyan-400 rounded-full opacity-70"></div>
        <div class="absolute bottom-24 left-20 w-3 h-3 bg-blue-400 rounded-full opacity-60"></div>
        <div class="absolute top-1/3 left-1/4 w-1 h-1 bg-white rounded-full opacity-60"></div>

    </div>

    <!-- Login Content -->
    <main class="relative flex items-center justify-center min-h-screen py-12 px-6">

        {{ $slot }}

    </main>

</body>
</html>