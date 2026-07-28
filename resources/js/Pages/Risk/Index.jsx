import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';
import { ShieldAlert, TrendingUp, Search, CloudRain, DollarSign, Newspaper, Activity, AlertTriangle, CheckCircle } from 'lucide-react';

export default function Index({ auth, countries, summary }) {
    const [search, setSearch] = useState('');
    const [filterStatus, setFilterStatus] = useState('All');

    const filteredCountries = countries.filter(country => {
        const matchesSearch = country.name.toLowerCase().includes(search.toLowerCase().trim()) ||
                              country.region.toLowerCase().includes(search.toLowerCase().trim());
        const matchesFilter = filterStatus === 'All' || country.status === filterStatus;
        return matchesSearch && matchesFilter;
    });

    const getStatusBadge = (status) => {
        switch (status) {
            case 'High Risk':
                return 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 border-red-200 dark:border-red-800';
            case 'Medium Risk':
                return 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300 border-amber-200 dark:border-amber-800';
            default:
                return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800';
        }
    };

    const getProgressColor = (score) => {
        if (score >= 66.66) return 'bg-red-500';
        if (score >= 33.33) return 'bg-amber-500';
        return 'bg-emerald-500';
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center gap-3">
                    <TrendingUp className="w-6 h-6 text-indigo-500" />
                    <h2 className="text-2xl font-bold leading-tight text-slate-800 dark:text-slate-200">
                        Risk Prediction Intelligence
                    </h2>
                </div>
            }
        >
            <Head title="Risk Prediction" />

            <div className="py-8 bg-slate-50 dark:bg-slate-900 min-h-screen">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

                    {/* Overview Cards */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-100 dark:border-slate-700 shadow-sm flex items-center gap-4">
                            <div className="p-3.5 bg-indigo-50 dark:bg-indigo-900/40 rounded-xl text-indigo-600 dark:text-indigo-400">
                                <Activity className="w-6 h-6" />
                            </div>
                            <div>
                                <p className="text-xs text-slate-500 dark:text-slate-400 font-medium">Rata-Rata Skor Risiko</p>
                                <h4 className="text-2xl font-black text-slate-800 dark:text-white">{summary.average_risk}%</h4>
                            </div>
                        </div>

                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-100 dark:border-slate-700 shadow-sm flex items-center gap-4">
                            <div className="p-3.5 bg-red-50 dark:bg-red-900/40 rounded-xl text-red-600 dark:text-red-400">
                                <ShieldAlert className="w-6 h-6" />
                            </div>
                            <div>
                                <p className="text-xs text-slate-500 dark:text-slate-400 font-medium">Risiko Tinggi (High)</p>
                                <h4 className="text-2xl font-black text-red-600 dark:text-red-400">{summary.high_risk} <span className="text-xs font-normal text-slate-400">Negara</span></h4>
                            </div>
                        </div>

                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-100 dark:border-slate-700 shadow-sm flex items-center gap-4">
                            <div className="p-3.5 bg-amber-50 dark:bg-amber-900/40 rounded-xl text-amber-600 dark:text-amber-400">
                                <AlertTriangle className="w-6 h-6" />
                            </div>
                            <div>
                                <p className="text-xs text-slate-500 dark:text-slate-400 font-medium">Risiko Sedang (Medium)</p>
                                <h4 className="text-2xl font-black text-amber-600 dark:text-amber-400">{summary.medium_risk} <span className="text-xs font-normal text-slate-400">Negara</span></h4>
                            </div>
                        </div>

                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-100 dark:border-slate-700 shadow-sm flex items-center gap-4">
                            <div className="p-3.5 bg-emerald-50 dark:bg-emerald-900/40 rounded-xl text-emerald-600 dark:text-emerald-400">
                                <CheckCircle className="w-6 h-6" />
                            </div>
                            <div>
                                <p className="text-xs text-slate-500 dark:text-slate-400 font-medium">Risiko Rendah (Low)</p>
                                <h4 className="text-2xl font-black text-emerald-600 dark:text-emerald-400">{summary.low_risk} <span className="text-xs font-normal text-slate-400">Negara</span></h4>
                            </div>
                        </div>
                    </div>

                    {/* Filter & Search Bar */}
                    <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm space-y-6">
                        <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div className="flex items-center gap-2 overflow-x-auto w-full md:w-auto">
                                {['All', 'High Risk', 'Medium Risk', 'Low Risk'].map((status) => (
                                    <button
                                        key={status}
                                        onClick={() => setFilterStatus(status)}
                                        className={`px-4 py-2 rounded-xl text-sm font-semibold transition-all whitespace-nowrap ${
                                            filterStatus === status
                                                ? 'bg-indigo-600 text-white shadow-sm'
                                                : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600'
                                        }`}
                                    >
                                        {status === 'All' ? 'Semua Negara' : status}
                                    </button>
                                ))}
                            </div>

                            <div className="relative w-full md:w-72">
                                <Search className="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" />
                                <input
                                    type="text"
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    placeholder="Cari negara atau kawasan..."
                                    className="w-full pl-10 pr-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl text-sm bg-slate-50 dark:bg-slate-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                />
                            </div>
                        </div>

                        {/* Country Cards */}
                        {filteredCountries.length === 0 ? (
                            <div className="text-center py-12 text-slate-500 dark:text-slate-400">
                                <p className="text-base font-medium">Tidak ada data risiko yang sesuai dengan kriteria pencarian.</p>
                            </div>
                        ) : (
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                {filteredCountries.map((country) => (
                                    <div key={country.id} className="bg-slate-50/50 dark:bg-slate-800/80 rounded-2xl p-5 border border-slate-200 dark:border-slate-700 flex flex-col justify-between hover:border-indigo-400 dark:hover:border-indigo-500 transition-all">
                                        <div>
                                            <div className="flex items-center justify-between mb-4">
                                                <div className="flex items-center gap-3">
                                                    <img src={country.flag} alt={country.name} className="w-10 h-7 rounded object-cover shadow-sm" />
                                                    <div>
                                                        <h4 className="font-bold text-slate-800 dark:text-white">{country.name}</h4>
                                                        <p className="text-xs text-slate-500 dark:text-slate-400">{country.region}</p>
                                                    </div>
                                                </div>
                                                <span className={`px-2.5 py-1 rounded-full text-xs font-bold border ${getStatusBadge(country.status)}`}>
                                                    {country.status}
                                                </span>
                                            </div>

                                            {/* Overall score gauge */}
                                            <div className="mb-4 bg-white dark:bg-slate-700/50 p-3.5 rounded-xl border border-slate-100 dark:border-slate-700">
                                                <div className="flex justify-between items-center mb-1.5 text-xs font-semibold text-slate-700 dark:text-slate-200">
                                                    <span>Skor Prediksi Risiko Total</span>
                                                    <span className="font-bold text-sm">{country.total_risk}%</span>
                                                </div>
                                                <div className="w-full h-2.5 bg-slate-200 dark:bg-slate-600 rounded-full overflow-hidden">
                                                    <div
                                                        className={`h-full transition-all duration-500 ${getProgressColor(country.total_risk)}`}
                                                        style={{ width: `${country.total_risk}%` }}
                                                    />
                                                </div>
                                            </div>

                                            {/* Breakdown Factors */}
                                            <div className="space-y-2.5 text-xs">
                                                <div className="flex items-center justify-between text-slate-600 dark:text-slate-300">
                                                    <span className="flex items-center gap-1.5">
                                                        <CloudRain className="w-3.5 h-3.5 text-sky-500" /> Cuaca Ekstrem (30%)
                                                    </span>
                                                    <span className="font-bold">{country.breakdown.weather}%</span>
                                                </div>
                                                <div className="flex items-center justify-between text-slate-600 dark:text-slate-300">
                                                    <span className="flex items-center gap-1.5">
                                                        <DollarSign className="w-3.5 h-3.5 text-amber-500" /> Inflasi (20%)
                                                    </span>
                                                    <span className="font-bold">{country.breakdown.inflation}%</span>
                                                </div>
                                                <div className="flex items-center justify-between text-slate-600 dark:text-slate-300">
                                                    <span className="flex items-center gap-1.5">
                                                        <Activity className="w-3.5 h-3.5 text-emerald-500" /> Kurs Mata Uang (10%)
                                                    </span>
                                                    <span className="font-bold">{country.breakdown.exchange}%</span>
                                                </div>
                                                <div className="flex items-center justify-between text-slate-600 dark:text-slate-300">
                                                    <span className="flex items-center gap-1.5">
                                                        <Newspaper className="w-3.5 h-3.5 text-purple-500" /> Sentimen Berita (40%)
                                                    </span>
                                                    <span className="font-bold">{country.breakdown.news}%</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div className="mt-5 pt-3 border-t border-slate-200 dark:border-slate-700 flex justify-end">
                                            <Link
                                                href={route('countries.show', country.id)}
                                                className="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1"
                                            >
                                                Lihat Detail Analisis &rarr;
                                            </Link>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
