import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';
import { useState } from 'react';
import { ArrowLeftRight, TrendingDown, TrendingUp, AlertTriangle } from 'lucide-react';
import { 
    BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip as RechartsTooltip, ResponsiveContainer, Legend
} from 'recharts';

export default function Index({ auth, countries, countryA, countryB }) {
    const [selectedA, setSelectedA] = useState(countryA?.id || '');
    const [selectedB, setSelectedB] = useState(countryB?.id || '');

    const handleCompare = () => {
        router.get(route('compare'), { country_a: selectedA, country_b: selectedB }, { preserveState: true });
    };

    const formatNumber = (num) => {
        if (!num) return '0';
        if (num >= 1e12) return (num / 1e12).toFixed(2) + 'T';
        if (num >= 1e9) return (num / 1e9).toFixed(2) + 'B';
        if (num >= 1e6) return (num / 1e6).toFixed(2) + 'M';
        return new Intl.NumberFormat().format(num);
    };

    const comparisonData = [
        {
            name: 'GDP (USD)',
            [countryA?.name]: parseFloat(countryA?.gdp) || 0,
            [countryB?.name]: parseFloat(countryB?.gdp) || 0,
        },
        {
            name: 'Inflation (%)',
            [countryA?.name]: parseFloat(countryA?.inflation) || 0,
            [countryB?.name]: parseFloat(countryB?.inflation) || 0,
        },
        {
            name: 'Risk Score',
            [countryA?.name]: parseFloat(countryA?.riskScore?.total_score) || 0,
            [countryB?.name]: parseFloat(countryB?.riskScore?.total_score) || 0,
        }
    ];

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="text-xl font-semibold leading-tight text-slate-800 dark:text-slate-200">Country Comparison Matrix</h2>}
        >
            <Head title="Compare Countries" />

            <div className="py-8 bg-slate-50 dark:bg-slate-900 min-h-screen">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                    
                    {/* Controls */}
                    <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm flex flex-col md:flex-row items-center gap-4 justify-center">
                        <select 
                            value={selectedA} 
                            onChange={e => setSelectedA(e.target.value)}
                            className="w-full md:w-64 border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            {countries.map(c => <option key={c.id} value={c.id}>{c.name}</option>)}
                        </select>
                        
                        <div className="p-3 bg-indigo-50 dark:bg-indigo-500/10 rounded-full text-indigo-600 dark:text-indigo-400">
                            <ArrowLeftRight className="w-5 h-5" />
                        </div>
                        
                        <select 
                            value={selectedB} 
                            onChange={e => setSelectedB(e.target.value)}
                            className="w-full md:w-64 border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            {countries.map(c => <option key={c.id} value={c.id}>{c.name}</option>)}
                        </select>

                        <button 
                            onClick={handleCompare}
                            className="w-full md:w-auto px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors"
                        >
                            Compare Now
                        </button>
                    </div>

                    {/* Comparison Cards */}
                    {countryA && countryB && (
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {[countryA, countryB].map((country, index) => (
                                <div key={country.id} className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm relative overflow-hidden">
                                    <div className="flex items-center gap-4 mb-6 relative z-10">
                                        <img src={country.flag} alt={country.name} className="w-16 h-12 rounded object-cover shadow" />
                                        <div>
                                            <h3 className="text-2xl font-bold text-slate-800 dark:text-white">{country.name}</h3>
                                            <p className="text-sm text-slate-500">{country.region}</p>
                                        </div>
                                    </div>
                                    
                                    <div className="space-y-4 relative z-10">
                                        <div className="flex justify-between items-center py-3 border-b border-slate-100 dark:border-slate-700">
                                            <span className="text-slate-500 dark:text-slate-400">GDP</span>
                                            <span className="font-bold text-slate-800 dark:text-white">${formatNumber(country.gdp)}</span>
                                        </div>
                                        <div className="flex justify-between items-center py-3 border-b border-slate-100 dark:border-slate-700">
                                            <span className="text-slate-500 dark:text-slate-400">Inflation</span>
                                            <span className="font-bold text-slate-800 dark:text-white flex items-center gap-1">
                                                {country.inflation}%
                                                {country.inflation > 5 ? <TrendingUp className="w-4 h-4 text-red-500" /> : <TrendingDown className="w-4 h-4 text-emerald-500" />}
                                            </span>
                                        </div>
                                        <div className="flex justify-between items-center py-3 border-b border-slate-100 dark:border-slate-700">
                                            <span className="text-slate-500 dark:text-slate-400">Risk Score</span>
                                            <span className="font-bold text-slate-800 dark:text-white flex items-center gap-1">
                                                {country.riskScore?.total_score || 'N/A'}
                                                <AlertTriangle className="w-4 h-4 text-amber-500" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}

                    {/* Chart */}
                    {countryA && countryB && (
                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <h3 className="text-lg font-bold text-slate-800 dark:text-white mb-6">Head-to-Head Visualization</h3>
                            <div className="h-[400px]">
                                <ResponsiveContainer width="100%" height="100%">
                                    <BarChart data={comparisonData} margin={{ top: 20, right: 30, left: 20, bottom: 5 }}>
                                        <CartesianGrid strokeDasharray="3 3" vertical={false} stroke="#334155" opacity={0.2} />
                                        <XAxis dataKey="name" axisLine={false} tickLine={false} tick={{fill: '#64748b'}} />
                                        <YAxis axisLine={false} tickLine={false} tick={{fill: '#64748b'}} />
                                        <RechartsTooltip 
                                            cursor={{fill: 'transparent'}}
                                            contentStyle={{borderRadius: '12px', border: 'none', boxShadow: '0 4px 6px -1px rgb(0 0 0 / 0.1)'}}
                                        />
                                        <Legend wrapperStyle={{paddingTop: '20px'}} />
                                        <Bar dataKey={countryA.name} fill="#6366f1" radius={[4, 4, 0, 0]} />
                                        <Bar dataKey={countryB.name} fill="#14b8a6" radius={[4, 4, 0, 0]} />
                                    </BarChart>
                                </ResponsiveContainer>
                            </div>
                        </div>
                    )}

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
