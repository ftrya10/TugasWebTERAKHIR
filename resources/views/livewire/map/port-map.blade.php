<div wire:poll.300s="loadPorts" class="w-full h-[600px] rounded-xl overflow-hidden shadow-lg border border-slate-700 bg-slate-900" id="map-container">
    <div id="leaflet-map" class="w-full h-full z-0" wire:ignore></div>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <style>
        /* Deep Dark Mode for Map Controls */
        .leaflet-container {
            background-color: #0f172a; /* slate-900 */
        }
        .leaflet-bar a {
            background-color: #1e293b !important; /* slate-800 */
            color: #34d399 !important; /* emerald-400 */
            border-bottom: 1px solid #334155 !important;
        }
        .leaflet-popup-content-wrapper, .leaflet-popup-tip {
            background: #1e293b;
            color: #f8fafc;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5);
        }
        .marker-cluster-small, .marker-cluster-medium, .marker-cluster-large {
            background-color: rgba(52, 211, 153, 0.6); /* emerald-400 */
        }
        .marker-cluster-small div, .marker-cluster-medium div, .marker-cluster-large div {
            background-color: rgba(16, 185, 129, 0.9);
            color: #fff;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const map = L.map('leaflet-map').setView([20, 0], 2);

            // Using CartoDB Dark Matter for Deep Dark aesthetics
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 20
            }).addTo(map);

            let markers = L.markerClusterGroup({
                chunkedLoading: true,
                maxClusterRadius: 50
            });
            map.addTo(map); // Need to attach markers layer to map

            const updateMap = (ports) => {
                markers.clearLayers();
                
                ports.forEach(port => {
                    // Accent colors: Emerald for active, Rose for inactive/risk
                    let markerColor = port.status === 'active' ? '#34d399' : '#f43f5e';
                    
                    let customIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style='background-color:${markerColor}; width:12px; height:12px; border-radius:50%; border:2px solid #0f172a;'></div>`,
                        iconSize: [12, 12],
                        iconAnchor: [6, 6]
                    });

                    let marker = L.marker([port.latitude, port.longitude], {icon: customIcon})
                        .bindPopup(`<b>${port.name}</b><br/>Status: <span style="color:${markerColor}">${port.status}</span>`);
                    markers.addLayer(marker);
                });
                
                map.addLayer(markers);
            };

            // Initial load
            updateMap(@this.ports);

            // Listen for Livewire updates (e.g. after poll)
            Livewire.hook('message.processed', (message, component) => {
                if (component.name === 'map.port-map') {
                    updateMap(component.get('ports'));
                }
            });
        });
    </script>
    @endpush
</div>
