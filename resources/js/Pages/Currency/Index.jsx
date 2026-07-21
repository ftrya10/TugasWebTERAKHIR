import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';
import { DollarSign, TrendingUp, TrendingDown, RefreshCw, ArrowLeftRight } from 'lucide-react';
import {
    AreaChart, Area, XAxis, YAxis, CartesianGrid, Tooltip as RechartsTooltip, ResponsiveContainer
} from 'recharts';

export default function Index({ auth, countries }) {
    const [fromAmount, setFromAmount] = useState(1);
    const [fromCurrency, setFromCurrency] = useState('USD');
    const [toCurrency, setToCurrency] = useState('');
    const [converted, setConverted] = useState(null);

    // Build currency rate map from countries — support both camelCase and snake_case
    const currencyRates = {};
    countries.forEach(c => {
        const er = c.exchange_rate || c.exchangeRate;
        if (er?.currency) {
            currencyRates[er.currency] = {
                rate: parseFloat(er.rate),
                flag: c.flag,
                country: c.name
            };
        }
    });

    const currencyList = Object.entries(currencyRates).map(([code, data]) => ({ code, ...data }));

    const handleConvert = () => {
        if (!toCurrency || !currencyRates[toCurrency]) return;

        // Conversion logic: from USD to target currency
        // rate = how many units of target currency per 1 USD
        if (fromCurrency === 'USD') {
            const result = fromAmount * currencyRates[toCurrency].rate;
            setConverted(result.toFixed(4));
        } else if (toCurrency === 'USD') {
            const result = fromAmount / currencyRates[fromCurrency].rate;
            setConverted(result.toFixed(4));
        } else {
            // Cross-currency: convert from -> USD -> to
            const usdAmount = fromAmount / currencyRates[fromCurrency].rate;
            const result = usdAmount * currencyRates[toCurrency].rate;
            setConverted(result.toFixed(4));
        }
    };

    // Generate sparkline data for each currency (simulated 7-day trend)
    const generateTrend = (baseRate) => {
        return Array.from({ length: 7 }, (_, i) => ({
            day: `D-${6 - i}`,
            rate: +(baseRate * (1 + (Math.random() - 0.5) * 0.02)).toFixed(4)
        }));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="text-xl font-semibold leading-tight text-slate-800 dark:text-slate-200">Currency Impact Dashboard</h2>}
        >
            <Head title="Currency Impact" />

            <div className="py-8 bg-slate-50 dark:bg-slate-900 min-h-screen">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

                    {/* Currency Converter */}
                    <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                        <h3 className="text-lg font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                            <ArrowLeftRight className="w-5 h-5 text-indigo-500" />
                            Real-Time Currency Converter
                        </h3>
                        <div className="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div>
                                <label className="block text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">Amount</label>
                                <input
                                    type="number"
                                    value={fromAmount}
                                    onChange={e => setFromAmount(e.target.value)}
                                    min="0"
                                    className="w-full border border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">From</label>
                                <select
                                    value={fromCurrency}
                                    onChange={e => { setFromCurrency(e.target.value); setConverted(null); }}
                                    className="w-full border border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                >
                                    <option value="USD">USD (United States)</option>
                                    {currencyList.filter(c => c.code !== 'USD').map(c => (
                                        <option key={c.code} value={c.code}>{c.code} ({c.country})</option>
                                    ))}
                                </select>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">To Currency</label>
                                <select
                                    value={toCurrency}
                                    onChange={e => setToCurrency(e.target.value)}
                                    className="w-full border border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                >
                                    <option value="">-- Select currency --</option>
                                    {currencyList.filter(c => c.code !== fromCurrency).map(c => (
                                        <option key={c.code} value={c.code}>{c.code} ({c.country})</option>
                                    ))}
                                </select>
                            </div>
                            <button
                                onClick={handleConvert}
                                className="flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition-colors"
                            >
                                <RefreshCw className="w-4 h-4" />
                                Convert
                            </button>
                        </div>

                        {converted && (
                            <div className="mt-6 p-5 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-700 rounded-xl text-center">
                                <p className="text-sm text-indigo-600 dark:text-indigo-400 font-medium">Conversion Result</p>
                                <h2 className="text-4xl font-extrabold text-indigo-700 dark:text-indigo-300 mt-2">
                                    {fromAmount} {fromCurrency} = {converted} {toCurrency}
                                </h2>
                                <p className="text-xs text-indigo-400 mt-2">Based on latest rate from database</p>
                            </div>
                        )}
                    </div>

                    {/* Exchange Rate Cards Grid */}
                    <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        {countries.filter(c => (c.exchange_rate || c.exchangeRate)).map(country => {
                            const er = country.exchange_rate || country.exchangeRate;
                            const trend = generateTrend(er.rate);
                            const isUp = trend[trend.length - 1].rate >= trend[0].rate;

                            return (
                                <div key={country.id} className="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all">
                                    <div className="flex items-center justify-between mb-4">
                                        <div className="flex items-center gap-3">
                                            <img src={country.flag} alt={country.name} className="w-10 h-7 rounded object-cover shadow-sm" />
                                            <div>
                                                <h4 className="font-bold text-slate-800 dark:text-white">{country.name}</h4>
                                                <span className="text-xs text-slate-500">{er.currency}</span>
                                            </div>
                                        </div>
                                        <div className={`flex items-center gap-1 text-sm font-semibold ${isUp ? 'text-red-500' : 'text-emerald-500'}`}>
                                            {isUp ? <TrendingUp className="w-4 h-4" /> : <TrendingDown className="w-4 h-4" />}
                                            {isUp ? '+0.12%' : '-0.08%'}
                                        </div>
                                    </div>

                                    <div className="mb-3">
                                        <p className="text-2xl font-extrabold text-slate-800 dark:text-white">
                                            {parseFloat(er.rate).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                        </p>
                                        <p className="text-xs text-slate-500 mt-0.5">{er.currency} per 1 USD</p>
                                    </div>

                                    <div className="h-[80px]">
                                        <ResponsiveContainer width="100%" height="100%">
                                            <AreaChart data={trend} margin={{ top: 0, right: 0, left: 0, bottom: 0 }}>
                                                <defs>
                                                    <linearGradient id={`g-${country.id}`} x1="0" y1="0" x2="0" y2="1">
                                                        <stop offset="5%" stopColor={isUp ? '#ef4444' : '#22c55e'} stopOpacity={0.3} />
                                                        <stop offset="95%" stopColor={isUp ? '#ef4444' : '#22c55e'} stopOpacity={0} />
                                                    </linearGradient>
                                                </defs>
                                                <RechartsTooltip
                                                    contentStyle={{ borderRadius: '8px', border: 'none', fontSize: '11px', boxShadow: '0 2px 8px rgba(0,0,0,0.1)' }}
                                                />
                                                <Area
                                                    type="monotone"
                                                    dataKey="rate"
                                                    stroke={isUp ? '#ef4444' : '#22c55e'}
                                                    strokeWidth={2}
                                                    fill={`url(#g-${country.id})`}
                                                    dot={false}
                                                />
                                            </AreaChart>
                                        </ResponsiveContainer>
                                    </div>
                                </div>
                            );
                        })}
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
