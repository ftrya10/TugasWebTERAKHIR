<div class="bg-slate-800 p-6 rounded-xl shadow-lg border border-slate-700 mt-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-emerald-400">Compare Mode: Side-by-Side Analytics</h3>
        
        <div class="flex space-x-4">
            <select wire:model.live="country1Id" class="bg-slate-900 border border-slate-700 text-slate-300 rounded-lg px-3 py-1 focus:ring-emerald-500 focus:border-emerald-500">
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            <span class="text-slate-500 py-1">VS</span>
            <select wire:model.live="country2Id" class="bg-slate-900 border border-slate-700 text-slate-300 rounded-lg px-3 py-1 focus:ring-emerald-500 focus:border-emerald-500">
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($chartData)
        <div id="compare-chart" class="w-full h-80" wire:ignore></div>
    @else
        <div class="text-slate-500 text-center py-10">Please select two countries to compare.</div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            let chartData = @json($chartData);
            let chartOptions = {
                chart: {
                    type: 'bar',
                    height: 350,
                    background: 'transparent',
                    toolbar: { show: false }
                },
                series: chartData.series,
                xaxis: {
                    categories: chartData.categories,
                    labels: { style: { colors: '#94a3b8' } }
                },
                yaxis: {
                    labels: { style: { colors: '#94a3b8' } }
                },
                colors: ['#34d399', '#f43f5e'], /* Emerald-400, Rose-500 */
                theme: {
                    mode: 'dark'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '50%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: { enabled: false },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                grid: { borderColor: '#334155' }, // slate-700
                legend: { labels: { colors: '#f8fafc' } }
            };

            let chart = new ApexCharts(document.querySelector("#compare-chart"), chartOptions);
            chart.render();

            Livewire.hook('message.processed', (message, component) => {
                if (component.name === 'analytics.country-compare') {
                    const newData = component.get('chartData');
                    if (newData) {
                        chart.updateSeries(newData.series);
                        chart.updateOptions({ xaxis: { categories: newData.categories } });
                    }
                }
            });
        });
    </script>
    @endpush
</div>
