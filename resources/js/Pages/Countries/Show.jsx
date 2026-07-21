import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { 
    Activity, Globe, TrendingUp, Users, Wind, DollarSign, Newspaper, ArrowLeft
} from 'lucide-react';
import { 
    LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip as RechartsTooltip, ResponsiveContainer, AreaChart, Area
} from 'recharts';

export default function Show({ auth, country }) {
    const [localTime, setLocalTime] = React.useState('');

    // Common timezone mappings based on country code
    const getTimezone = (code) => {
        const map = {
            'ID': 'Asia/Jakarta', 'US': 'America/New_York', 'CN': 'Asia/Shanghai', 
            'DE': 'Europe/Berlin', 'AU': 'Australia/Sydney', 'GB': 'Europe/London',
            'JP': 'Asia/Tokyo', 'SG': 'Asia/Singapore', 'MY': 'Asia/Kuala_Lumpur',
            'FR': 'Europe/Paris', 'IN': 'Asia/Kolkata', 'BR': 'America/Sao_Paulo',
            'CA': 'America/Toronto', 'ZA': 'Africa/Johannesburg', 'AE': 'Asia/Dubai',
            'RU': 'Europe/Moscow', 'KR': 'Asia/Seoul', 'IT': 'Europe/Rome'
        };
        return map[code] || 'UTC';
    };

    React.useEffect(() => {
        const tz = getTimezone(country.code);
        const updateTime = () => {
            const timeStr = new Date().toLocaleTimeString('en-US', { 
                timeZone: tz, 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                hour12: true 
            });
            setLocalTime(timeStr + ' (' + tz.split('/')[1]?.replace('_', ' ') || 'UTC' + ')');
        };
        
        updateTime();
        const timer = setInterval(updateTime, 1000);
        return () => clearInterval(timer);
    }, [country.code]);

    const formatNumber = (num) => {
        if (!num) return '0';
        if (num >= 1e12) return (num / 1e12).toFixed(2) + 'T';
        if (num >= 1e9) return (num / 1e9).toFixed(2) + 'B';
        if (num >= 1e6) return (num / 1e6).toFixed(2) + 'M';
        return new Intl.NumberFormat().format(num);
    };

    // Simulate historical data for the charts since we only have current data
    const currentYear = new Date().getFullYear();
    const gdpTrend = Array.from({length: 5}, (_, i) => {
        const year = currentYear - 4 + i;
        // Simulate a steady 3-5% growth rate backwards
        const value = country.gdp / Math.pow(1.04, 4 - i);
        return { year: year.toString(), value };
    });

    const inflationTrend = Array.from({length: 5}, (_, i) => {
        const year = currentYear - 4 + i;
        // Randomize historical inflation slightly around the current inflation
        const fluctuation = (Math.random() - 0.5) * 2;
        return { year: year.toString(), value: Math.max(0, Number(country.inflation) + fluctuation).toFixed(2) };
    });

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center gap-4">
                    <Link href={route('dashboard')} className="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        <ArrowLeft className="w-5 h-5 text-slate-600 dark:text-slate-300" />
                    </Link>
                    <img src={country.flag} alt={country.name} className="w-10 h-7 rounded object-cover shadow-sm" />
                    <div>
                        <h2 className="text-2xl font-bold leading-tight tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                            {country.official_name || country.name}
                        </h2>
                        <div className="text-sm text-slate-500 dark:text-slate-400">
                            {country.region} • {country.subregion} • Capital: {country.capital} 
                        </div>
                        <div className="text-sm font-semibold text-indigo-500 mt-1">
                            🕒 {localTime}
                        </div>
                    </div>
                </div>
            }
        >
            <Head title={`${country.name} Intelligence`} />

            <div className="py-8 bg-slate-50 dark:bg-slate-900 min-h-screen">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                    
                    {/* Basic Info Cards */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <div className="flex justify-between items-start">
                                <div>
                                    <p className="text-sm font-medium text-slate-500 dark:text-slate-400">GDP (Current USD)</p>
                                    <h3 className="text-2xl font-bold text-slate-800 dark:text-white mt-1">
                                        ${formatNumber(country.gdp)}
                                    </h3>
                                </div>
                                <div className="p-2 bg-blue-50 dark:bg-blue-500/10 rounded-lg text-blue-600 dark:text-blue-400">
                                    <DollarSign className="w-5 h-5" />
                                </div>
                            </div>
                        </div>

                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <div className="flex justify-between items-start">
                                <div>
                                    <p className="text-sm font-medium text-slate-500 dark:text-slate-400">Currency ({country.currency})</p>
                                    <h3 className="text-2xl font-bold text-slate-800 dark:text-white mt-1">
                                        {country.exchangeRate ? `${parseFloat(country.exchangeRate.rate).toFixed(2)}` : 'N/A'}
                                    </h3>
                                    <p className="text-xs text-slate-500 mt-1">per 1 USD</p>
                                </div>
                                <div className="p-2 bg-rose-50 dark:bg-rose-500/10 rounded-lg text-rose-600 dark:text-rose-400">
                                    <DollarSign className="w-5 h-5" />
                                </div>
                            </div>
                        </div>

                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <div className="flex justify-between items-start">
                                <div>
                                    <p className="text-sm font-medium text-slate-500 dark:text-slate-400">Population</p>
                                    <h3 className="text-2xl font-bold text-slate-800 dark:text-white mt-1">
                                        {formatNumber(country.population)}
                                    </h3>
                                </div>
                                <div className="p-2 bg-indigo-50 dark:bg-indigo-500/10 rounded-lg text-indigo-600 dark:text-indigo-400">
                                    <Users className="w-5 h-5" />
                                </div>
                            </div>
                        </div>

                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <div className="flex justify-between items-start">
                                <div>
                                    <p className="text-sm font-medium text-slate-500 dark:text-slate-400">Weather Risk</p>
                                    <h3 className="text-2xl font-bold text-slate-800 dark:text-white mt-1">
                                        {country.weather?.condition || 'Unknown'}
                                    </h3>
                                </div>
                                <div className="p-2 bg-amber-50 dark:bg-amber-500/10 rounded-lg text-amber-600 dark:text-amber-400">
                                    <Wind className="w-5 h-5" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Charts */}
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        
                        {/* GDP Chart */}
                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <h3 className="text-lg font-bold text-slate-800 dark:text-white mb-6">GDP Growth Trend</h3>
                            <div className="h-[300px]">
                                <ResponsiveContainer width="100%" height="100%">
                                    <AreaChart data={gdpTrend} margin={{ top: 10, right: 10, left: 0, bottom: 0 }}>
                                        <defs>
                                            <linearGradient id="colorGdp" x1="0" y1="0" x2="0" y2="1">
                                                <stop offset="5%" stopColor="#3b82f6" stopOpacity={0.3}/>
                                                <stop offset="95%" stopColor="#3b82f6" stopOpacity={0}/>
                                            </linearGradient>
                                        </defs>
                                        <CartesianGrid strokeDasharray="3 3" vertical={false} stroke="#334155" opacity={0.2} />
                                        <XAxis dataKey="year" axisLine={false} tickLine={false} tick={{fill: '#64748b'}} />
                                        <YAxis 
                                            axisLine={false} 
                                            tickLine={false} 
                                            tick={{fill: '#64748b'}} 
                                            tickFormatter={(val) => `$${formatNumber(val)}`}
                                        />
                                        <RechartsTooltip 
                                            contentStyle={{borderRadius: '12px', border: 'none', boxShadow: '0 4px 6px -1px rgb(0 0 0 / 0.1)'}}
                                            formatter={(value) => [`$${formatNumber(value)}`, 'GDP']}
                                        />
                                        <Area type="monotone" dataKey="value" stroke="#3b82f6" strokeWidth={3} fillOpacity={1} fill="url(#colorGdp)" />
                                    </AreaChart>
                                </ResponsiveContainer>
                            </div>
                        </div>

                        {/* Inflation Chart */}
                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <h3 className="text-lg font-bold text-slate-800 dark:text-white mb-6">Inflation Fluctuation</h3>
                            <div className="h-[300px]">
                                <ResponsiveContainer width="100%" height="100%">
                                    <LineChart data={inflationTrend} margin={{ top: 10, right: 10, left: 0, bottom: 0 }}>
                                        <CartesianGrid strokeDasharray="3 3" vertical={false} stroke="#334155" opacity={0.2} />
                                        <XAxis dataKey="year" axisLine={false} tickLine={false} tick={{fill: '#64748b'}} />
                                        <YAxis 
                                            axisLine={false} 
                                            tickLine={false} 
                                            tick={{fill: '#64748b'}} 
                                            tickFormatter={(val) => `${val}%`}
                                        />
                                        <RechartsTooltip 
                                            contentStyle={{borderRadius: '12px', border: 'none', boxShadow: '0 4px 6px -1px rgb(0 0 0 / 0.1)'}}
                                            formatter={(value) => [`${value}%`, 'Inflation']}
                                        />
                                        <Line type="monotone" dataKey="value" stroke="#f43f5e" strokeWidth={3} dot={{r: 4, strokeWidth: 2}} activeDot={{r: 6}} />
                                    </LineChart>
                                </ResponsiveContainer>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
