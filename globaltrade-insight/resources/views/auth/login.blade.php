<x-guest-layout>

<div class="w-full flex items-center justify-center py-12 px-6">

    <div class="w-full max-w-5xl grid lg:grid-cols-2 gap-10 items-center">

        <!-- Kiri -->
        <div class="hidden lg:block">

            <p class="text-blue-400 font-semibold tracking-widest uppercase mb-4">
                GlobalTrade Insight
            </p>

            <h1 class="text-5xl font-bold text-white leading-tight">
                Smart Decision Support for
                <span class="text-cyan-400">International Trade</span>
            </h1>

            <p class="text-slate-300 mt-6 text-lg leading-8">
                Pantau data perdagangan global, cuaca, kurs mata uang,
                dan analisis risiko negara dalam satu dashboard modern.
            </p>

            <div class="mt-10 grid grid-cols-2 gap-4">

                <div class="bg-white/5 rounded-xl p-5 border border-white/10">
                    <h3 class="text-cyan-400 font-semibold">🌍 250+</h3>
                    <p class="text-slate-300 mt-2">Data Negara</p>
                </div>

                <div class="bg-white/5 rounded-xl p-5 border border-white/10">
                    <h3 class="text-cyan-400 font-semibold">💱 Live</h3>
                    <p class="text-slate-300 mt-2">Nilai Tukar</p>
                </div>

                <div class="bg-white/5 rounded-xl p-5 border border-white/10">
                    <h3 class="text-cyan-400 font-semibold">🌦️ Weather</h3>
                    <p class="text-slate-300 mt-2">Informasi Cuaca</p>
                </div>

                <div class="bg-white/5 rounded-xl p-5 border border-white/10">
                    <h3 class="text-cyan-400 font-semibold">📊 Analytics</h3>
                    <p class="text-slate-300 mt-2">Risk Analysis</p>
                </div>

            </div>

        </div>

        <!-- Card Login -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-auto">

            <div class="text-center mb-8">

                <div class="w-14 h-14 rounded-xl bg-blue-600 flex items-center justify-center mx-auto text-2xl">
                    🌍
                </div>

                <h2 class="text-3xl font-bold text-slate-800 mt-5">
                    Selamat Datang
                </h2>

                <p class="text-slate-500 mt-2">
                    Login untuk mengakses dashboard
                </p>

            </div>

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <div class="mb-5">

                    <label class="text-slate-700 font-medium">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan email"
                        required>

                </div>

                <div class="mb-5">

                    <label class="text-slate-700 font-medium">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan password"
                        required>

                </div>

                <div class="flex justify-between items-center text-sm mb-6">

                    <label class="flex items-center gap-2 text-slate-600">

                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded">

                        Ingat saya

                    </label>

                    <a href="#" class="text-blue-600 hover:underline">
                        Lupa password?
                    </a>

                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition">

                    Masuk

                </button>

            </form>

        </div>

    </div>

</div>

</x-guest-layout>