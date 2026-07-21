<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
                🌍 GlobalTrade Insight
            </a>

            <!-- Menu Kanan -->
            <div class="flex items-center gap-4">

                <span class="text-gray-700">
                    {{ Auth::user()->name }}
                </span>

                <a href="{{ route('profile.edit') }}"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                        Logout
                    </button>
                </form>

            </div>

        </div>
    </div>
</nav>