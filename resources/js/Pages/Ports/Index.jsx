import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { Ship, Anchor, AlertTriangle, CheckCircle2 } from 'lucide-react';
import { MapContainer, TileLayer, Marker, Popup } from 'react-leaflet';
import 'leaflet/dist/leaflet.css';
import L from 'leaflet';

// Fix for default marker icon in react-leaflet
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon-2x.png',
    iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
});

export default function Index({ auth, countries }) {
    // Extract all ports from countries
    const allPorts = countries.flatMap(country => 
        (country.ports || []).map(port => ({
            ...port,
            countryName: country.name,
            countryFlag: country.flag
        }))
    );

    const getStatusColor = (status) => {
        switch(status?.toLowerCase()) {
            case 'active': return 'text-emerald-500 bg-emerald-50';
            case 'delayed': return 'text-amber-500 bg-amber-50';
            case 'congested': return 'text-orange-500 bg-orange-50';
            case 'critical': return 'text-red-500 bg-red-50';
            default: return 'text-slate-500 bg-slate-50';
        }
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="text-xl font-semibold leading-tight text-slate-800 dark:text-slate-200">Global Port Locations</h2>}
        >
            <Head title="Port Locations" />

            <div className="py-8 bg-slate-50 dark:bg-slate-900 min-h-screen">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                    
                    <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                        <div className="flex justify-between items-center mb-6">
                            <h3 className="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                                <Ship className="w-5 h-5 text-blue-500" />
                                Interactive Port Map
                            </h3>
                            <div className="flex gap-2">
                                <span className="px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Active</span>
                                <span className="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Congested</span>
                            </div>
                        </div>

                        <div className="h-[500px] w-full rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 relative z-0">
                            <MapContainer center={[20, 0]} zoom={2} style={{ height: '100%', width: '100%' }}>
                                <TileLayer
                                    url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                                    attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                />
                                {allPorts.map(port => (
                                    port.latitude && port.longitude && (
                                        <Marker key={port.id} position={[port.latitude, port.longitude]}>
                                            <Popup>
                                                <div className="p-1">
                                                    <div className="flex items-center gap-2 mb-2">
                                                        <img src={port.countryFlag} className="w-6 h-4 object-cover rounded" alt="" />
                                                        <span className="font-bold">{port.name}</span>
                                                    </div>
                                                    <p className="text-sm text-slate-600 mb-2">Status: <span className="capitalize font-semibold">{port.status}</span></p>
                                                    {port.city && <p className="text-xs text-slate-500">City: {port.city}</p>}
                                                </div>
                                            </Popup>
                                        </Marker>
                                    )
                                ))}
                            </MapContainer>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                        <h3 className="text-lg font-bold text-slate-800 dark:text-white mb-6">Port Directory</h3>
                        
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            {allPorts.map(port => (
                                <div key={port.id} className="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 flex items-start gap-3">
                                    <div className={`p-2 rounded-lg ${getStatusColor(port.status)}`}>
                                        <Anchor className="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h4 className="font-bold text-slate-800 dark:text-white leading-tight mb-1">{port.name}</h4>
                                        <div className="flex items-center gap-2 text-xs text-slate-500">
                                            <img src={port.countryFlag} className="w-4 h-3 object-cover rounded" alt="" />
                                            {port.countryName} {port.city ? `• ${port.city}` : ''}
                                        </div>
                                    </div>
                                </div>
                            ))}
                            {allPorts.length === 0 && (
                                <p className="text-slate-500 text-sm py-4 col-span-3 text-center">No ports recorded yet. Try running the data fetcher.</p>
                            )}
                        </div>
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
