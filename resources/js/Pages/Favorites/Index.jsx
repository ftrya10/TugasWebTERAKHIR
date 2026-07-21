import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';
import { useState } from 'react';
import { Star, Globe, Plus, Trash2, TrendingUp, ShieldAlert, Wind } from 'lucide-react';

export default function Index({ auth, watchlist, countries, watchlistIds }) {
    const [localIds, setLocalIds] = useState(watchlistIds);
    const [loading, setLoading] = useState(null);

    const toggle = (countryId) => {
        setLoading(countryId);
        router.post(route('favorites.toggle'), { country_id: countryId }, {
            preserveScroll: true,
            onSuccess: () => {
                if (localIds.includes(countryId)) {
                    setLocalIds(prev => prev.filter(id => id !== countryId));
                } else {
                    setLocalIds(prev => [...prev, countryId]);
                }
                setLoading(null);
            },
            onError: () => setLoading(null)
        });
    };

    const formatNumber = (num) => {
        if (!num) return '0';
        if (num >= 1e12) return (num / 1e12).toFixed(2) + 'T';
        if (num >= 1e9) return (num / 1e9).toFixed(2) + 'B';
        if (num >= 1e6) return (num / 1e6).toFixed(2) + 'M';
        return new Intl.NumberFormat().format(num);
    };

    const getRiskColor = (status) => {
        switch(status?.toLowerCase()) {
            case 'critical': return 'text-red-500';
            case 'high': return 'text-orange-500';
            case 'medium': return 'text-yellow-500';
            default: return 'text-emerald-500';
        }
    };

    const savedCountries = countries.filter(c => localIds.includes(c.id));
    const availableCountries = countries.filter(c => !localIds.includes(c.id));

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-slate-800 dark:text-slate-200 flex items-center gap-2">
                    <Star className="w-5 h-5 text-amber-400 fill-amber-400" />
                    My Watchlist
                </h2>
            }
        >
            <Head title="Favorite Watchlist" />

            <div className="py-8 bg-slate-50 dark:bg-slate-900 min-h-screen">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

                    {/* Watchlist */}
                    <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                        <h3 className="text-lg font-bold text-slate-800 dark:text-white mb-5">
                            Your Tracked Countries ({savedCountries.length})
                        </h3>

                        {savedCountries.length === 0 ? (
                            <div className="text-center py-10 text-slate-500 dark:text-slate-400">
                                <Star className="w-10 h-10 mx-auto mb-3 opacity-30" />
                                <p className="text-sm">You haven't added any countries to your watchlist yet.</p>
                            </div>
                        ) : (
                            <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                                {savedCountries.map(country => (
                                    <div key={country.id} className="p-4 rounded-xl border border-amber-200 dark:border-amber-700/40 bg-amber-50/30 dark:bg-amber-900/10 relative group">
                                        <button
                                            onClick={() => toggle(country.id)}
                                            disabled={loading === country.id}
                                            className="absolute top-3 right-3 p-1.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-500 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-200 dark:hover:bg-red-800"
                                        >
                                            <Trash2 className="w-3.5 h-3.5" />
                                        </button>

                                        <div className="flex items-center gap-3 mb-4">
                                            <img src={country.flag} alt={country.name} className="w-10 h-7 rounded object-cover shadow-sm" />
                                            <div>
                                                <h4 className="font-bold text-slate-800 dark:text-white">{country.name}</h4>
                                                <p className="text-xs text-slate-500">{country.region}</p>
                                            </div>
                                            <Star className="w-4 h-4 text-amber-400 fill-amber-400 ml-auto mr-7" />
                                        </div>

                                        <div className="grid grid-cols-3 gap-2 text-center">
                                            <div className="bg-white dark:bg-slate-800 rounded-lg p-2">
                                                <p className="text-xs text-slate-500">GDP</p>
                                                <p className="font-bold text-slate-800 dark:text-white text-sm">${formatNumber(country.gdp)}</p>
                                            </div>
                                            <div className="bg-white dark:bg-slate-800 rounded-lg p-2">
                                                <p className="text-xs text-slate-500">Inflation</p>
                                                <p className="font-bold text-slate-800 dark:text-white text-sm">{country.inflation}%</p>
                                            </div>
                                            <div className="bg-white dark:bg-slate-800 rounded-lg p-2">
                                                <p className="text-xs text-slate-500">Risk</p>
                                                <p className={`font-bold text-sm capitalize ${getRiskColor(country.riskScore?.status)}`}>
                                                    {country.riskScore?.status || 'N/A'}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>

                    {/* Add Countries */}
                    <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                        <h3 className="text-lg font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                            <Globe className="w-5 h-5 text-indigo-500" />
                            Add Countries to Watchlist
                        </h3>
                        <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                            {availableCountries.map(country => (
                                <div key={country.id} className="flex items-center justify-between p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-600 transition-colors">
                                    <div className="flex items-center gap-3">
                                        <img src={country.flag} alt={country.name} className="w-8 h-5 rounded object-cover" />
                                        <span className="font-medium text-slate-800 dark:text-white text-sm">{country.name}</span>
                                    </div>
                                    <button
                                        onClick={() => toggle(country.id)}
                                        disabled={loading === country.id}
                                        className="p-1.5 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-200 transition-colors disabled:opacity-50"
                                    >
                                        <Plus className="w-4 h-4" />
                                    </button>
                                </div>
                            ))}
                        </div>
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
