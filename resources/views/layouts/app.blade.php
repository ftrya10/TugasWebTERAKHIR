<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'GlobalTrade Insight')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-200">

    <div class="flex min-h-screen">
        
        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Content Area --}}
        <div class="flex-1 flex flex-col min-h-screen">
            
            {{-- Navbar --}}
            @include('partials.navbar')

            {{-- Main Content --}}
            <main class="flex-1 p-6 lg:p-8 overflow-y-auto bg-gray-50 dark:bg-gray-800 transition-colors duration-200">
                @yield('content')
            </main>

        </div>
    </div>

    {{-- Alpine.js untuk toggle dark mode --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>

</html>