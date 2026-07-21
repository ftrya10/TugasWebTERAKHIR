<nav class="bg-white dark:bg-gray-800 shadow-sm p-4 flex justify-between items-center">
    <h2 class="font-bold text-xl text-gray-900 dark:text-white">
        @yield('page_title', 'Dashboard')
    </h2>

    <div class="flex items-center gap-4">
        <button onclick="document.documentElement.classList.toggle('dark')" 
                class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-xl">
            🌓
        </button>

        <span class="font-medium text-gray-700 dark:text-gray-300 text-sm">
            {{ Auth::user()->name ?? 'Guest' }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition">
                Logout
            </button>
        </form>
    </div>
</nav>