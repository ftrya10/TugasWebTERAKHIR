<aside class="w-64 bg-gray-900 text-white min-h-screen p-4 flex-shrink-0">
    <div class="text-xl font-bold mb-8">🌍 GlobalTrade</div>
    
    <nav class="space-y-1">
        {{-- Admin --}}
        <div class="text-xs text-gray-500 uppercase tracking-wider mt-4 mb-2">ADMIN</div>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800' : '' }}">
            ⚙️ Admin Dashboard
        </a>
        <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition pl-8 {{ request()->routeIs('admin.users') ? 'bg-gray-800' : '' }}">
            👥 Manage Users
        </a>
        <a href="{{ route('admin.ports') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition pl-8 {{ request()->routeIs('admin.ports') ? 'bg-gray-800' : '' }}">
            ⚓ Port Dataset
        </a>
        <a href="{{ route('admin.articles') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition pl-8 {{ request()->routeIs('admin.articles') ? 'bg-gray-800' : '' }}">
            📄 Articles
        </a>
        
        {{-- Main --}}
        <div class="text-xs text-gray-500 uppercase tracking-wider mt-4 mb-2">MAIN</div>
        <a href="{{ route('countries.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('countries.*') ? 'bg-gray-800' : '' }}">
            🌍 Countries
        </a>
        <a href="{{ route('ports.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('ports.*') ? 'bg-gray-800' : '' }}">
            ⚓ Ports
        </a>
        <a href="{{ route('weather.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('weather.*') ? 'bg-gray-800' : '' }}">
            🌦️ Weather
        </a>
        <a href="{{ route('news.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('news.*') ? 'bg-gray-800' : '' }}">
            📰 News
        </a>
        <a href="{{ route('risk.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('risk.*') ? 'bg-gray-800' : '' }}">
            ⚠️ Risk Analysis
        </a>
    </nav>
</aside>