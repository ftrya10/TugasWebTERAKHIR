<div class="w-64 bg-blue-900 text-white min-h-screen">

    <div class="text-2xl font-bold p-6 border-b border-blue-700">
        GlobalTrade
    </div>

    <ul class="mt-5">

        <li>
            <a href="{{ route('dashboard') }}"
               class="block px-6 py-3 hover:bg-blue-700 {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('countries') }}"
               class="block px-6 py-3 hover:bg-blue-700 {{ request()->routeIs('countries') ? 'bg-blue-700' : '' }}">
                Countries
            </a>
        </li>

        <li>
            <a href="{{ route('trade') }}"
               class="block px-6 py-3 hover:bg-blue-700 {{ request()->routeIs('trade') ? 'bg-blue-700' : '' }}">
                Trade Analysis
            </a>
        </li>

        <li>
            <a href="{{ route('weather') }}"
               class="block px-6 py-3 hover:bg-blue-700 {{ request()->routeIs('weather') ? 'bg-blue-700' : '' }}">
                Weather
            </a>
        </li>

        <li>
            <a href="{{ route('exchange') }}"
               class="block px-6 py-3 hover:bg-blue-700 {{ request()->routeIs('exchange') ? 'bg-blue-700' : '' }}">
                Exchange Rate
            </a>
        </li>

        <li>
            <a href="{{ route('news') }}"
               class="block px-6 py-3 hover:bg-blue-700 {{ request()->routeIs('news') ? 'bg-blue-700' : '' }}">
                Global News
            </a>
        </li>

        <li>
            <a href="{{ route('port') }}"
               class="block px-6 py-3 hover:bg-blue-700 {{ request()->routeIs('port') ? 'bg-blue-700' : '' }}">
                Port Map
            </a>
        </li>

        <li>
            <a href="{{ route('risk') }}"
               class="block px-6 py-3 hover:bg-blue-700 {{ request()->routeIs('risk') ? 'bg-blue-700' : '' }}">
                Risk Analysis
            </a>
        </li>

        <li>
            <a href="{{ route('favorites') }}"
               class="block px-6 py-3 hover:bg-blue-700 {{ request()->routeIs('favorites') ? 'bg-blue-700' : '' }}">
                Favorites
            </a>
        </li>

    </ul>

</div>