<div class="min-h-screen bg-slate-900 text-slate-100 font-sans p-6">
    <div class="max-w-7xl mx-auto">
        <header class="mb-8 flex justify-between items-center border-b border-slate-700 pb-4">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-cyan-400">
                Global Supply Chain Intelligence
            </h1>
            <div class="text-slate-400 text-sm" wire:ignore>
                <span id="local-time" class="font-mono bg-slate-800 px-3 py-1 rounded border border-slate-700"></span>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar: Country List -->
            <div class="col-span-1 bg-slate-800 rounded-xl p-4 shadow-lg border border-slate-700">
                <h2 class="text-xl font-semibold mb-4 text-emerald-400">Countries</h2>
                <ul class="space-y-2">
                    @foreach($countries as $country)
                        <li>
                            <button 
                                wire:click="selectCountry({{ $country->id }})" 
                                class="w-full text-left px-4 py-2 rounded-lg transition duration-200 {{ $selectedCountryId === $country->id ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/50' : 'hover:bg-slate-700 text-slate-300' }}"
                                wire:navigate
                            >
                                {{ $country->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Main Content: Dashboard -->
            <div class="col-span-1 lg:col-span-3 space-y-6">
                @if($countryData)
                    <div class="bg-slate-800 p-6 rounded-xl shadow-lg border border-slate-700" wire:poll.300s="loadCountryData">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold">{{ $countryData->name }} Dashboard</h2>
                            @php
                                $trend = $countryData->marketTrends->first();
                            @endphp
                            <div class="px-3 py-1 rounded-full text-xs font-semibold {{ ($trend->risk_score ?? 0) > 50 ? 'bg-rose-500/20 text-rose-500 border border-rose-500/50' : 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/50' }}">
                                Risk Score: {{ $trend->risk_score ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                            <div class="bg-slate-900 p-4 rounded-lg border border-slate-700">
                                <div class="text-slate-400 text-sm">Currency</div>
                                <div class="text-xl font-mono text-cyan-400">{{ $countryData->currency }}</div>
                            </div>
                            <div class="bg-slate-900 p-4 rounded-lg border border-slate-700">
                                <div class="text-slate-400 text-sm">Rate (vs USD)</div>
                                <div class="text-xl font-mono text-emerald-400">{{ $trend->currency_rate ?? '-' }}</div>
                            </div>
                            <div class="bg-slate-900 p-4 rounded-lg border border-slate-700">
                                <div class="text-slate-400 text-sm">Inflation</div>
                                <div class="text-xl font-mono {{ ($trend->inflation_rate ?? 0) > 3 ? 'text-rose-400' : 'text-emerald-400' }}">{{ $trend->inflation_rate ?? '-' }}%</div>
                            </div>
                            <div class="bg-slate-900 p-4 rounded-lg border border-slate-700">
                                <div class="text-slate-400 text-sm">Weather</div>
                                <div class="text-xl text-slate-200">{{ $trend->weather_condition ?? '-' }}</div>
                            </div>
                        </div>

                        <!-- Map Component -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4 text-emerald-400">Global Port Infrastructure</h3>
                            @livewire('map.port-map')
                        </div>

                        <!-- Country Compare Component -->
                        @livewire('analytics.country-compare')
                    </div>
                @else
                    <div class="bg-slate-800 p-6 rounded-xl shadow-lg border border-slate-700 text-center text-slate-400">
                        Select a country to view supply chain intelligence.
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/utc.js"></script>
    <script>
        dayjs.extend(dayjs_plugin_utc);
        
        function updateTime() {
            // Display local UTC time for the user's perspective, or could be adapted per country timezone
            document.getElementById('local-time').innerText = dayjs().utc().format('YYYY-MM-DD HH:mm:ss [UTC]');
        }
        
        setInterval(updateTime, 1000);
        updateTime();
    </script>
    @endpush
</div>
