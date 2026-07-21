import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { 
    Activity, 
    Globe, 
    AlertTriangle, 
    Ship, 
    TrendingUp, 
    Users,
    Wind,
    DollarSign,
    Newspaper,
    ShieldAlert
} from 'lucide-react';
import { 
    BarChart, 
    Bar, 
    XAxis, 
    YAxis, 
    CartesianGrid, 
    Tooltip as RechartsTooltip, 
    ResponsiveContainer,
    Cell
} from 'recharts';

export default function Dashboard({ auth, stats, countries, recentNews }) {
    // Format large numbers
    const formatNumber = (num) => {
        if (num >= 1e12) return (num / 1e12).toFixed(2) + 'T';
        if (num >= 1e9) return (num / 1e9).toFixed(2) + 'B';
        if (num >= 1e6) return (num / 1e6).toFixed(2) + 'M';
        return new Intl.NumberFormat().format(num);
    };

    // Prepare chart data for risk scores
    const riskChartData = countries.map(c => ({
        name: c.code,
        fullName: c.name,
        score: c.riskScore?.total_score || 0
    })).sort((a, b) => b.score - a.score).slice(0, 10);

    const getRiskColor = (score) => {
        if (score >= 70) return '#ef4444'; // Red-500
        if (score >= 30) return '#eab308'; // Yellow-500
        return '#22c55e'; // Green-500
    };

    const getRiskBgColor = (riskLevel) => {
        switch(riskLevel?.toLowerCase()) {
            case 'critical': return 'bg-red-500/10 text-red-500 border-red-500/20';
            case 'high': return 'bg-orange-500/10 text-orange-500 border-orange-500/20';
            case 'medium': return 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20';
            default: return 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20';
        }
    };

    return (
        <AuthenticatedLayout
            header={
                <div className="flex justify-between items-center">
                    <h2 className="text-2xl font-bold leading-tight tracking-tight text-slate-900 dark:text-white">
                        Global Intelligence Command Center
                    </h2>
                    <div className={`px-4 py-1.5 rounded-full border flex items-center gap-2 font-semibold ${getRiskBgColor(stats.overall_risk)}`}>
                        <ShieldAlert className="w-5 h-5" />
                        Global Risk: {stats.overall_risk} ({stats.supply_chain_risk_score}%)
                    </div>
                </div>
            }
        >
            <Head title="Command Center" />

            <div className="py-8 bg-slate-50 dark:bg-slate-900 min-h-screen">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                    
                    {/* KPI Cards Section */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        
                        {/* KPI 1 */}
                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm transition-all hover:shadow-md">
                            <div className="flex justify-between items-start">
                                <div>
                                    <p className="text-sm font-medium text-slate-500 dark:text-slate-400">Total Global GDP</p>
                                    <h3 className="text-3xl font-bold text-slate-800 dark:text-white mt-2">
                                        ${formatNumber(countries.reduce((acc, c) => acc + (parseFloat(c.gdp) || 0), 0))}
                                    </h3>
                                </div>
                                <div className="p-3 bg-blue-50 dark:bg-blue-500/10 rounded-xl text-blue-600 dark:text-blue-400">
                                    <Globe className="w-6 h-6" />
                                </div>
                            </div>
                            <div className="mt-4 flex items-center text-sm">
                                <span className="text-emerald-500 flex items-center font-medium">
                                    <TrendingUp className="w-4 h-4 mr-1" />
                                    Highest: {stats.highest_gdp_country}
                                </span>
                            </div>
                        </div>

                        {/* KPI 2 */}
                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm transition-all hover:shadow-md">
                            <div className="flex justify-between items-start">
                                <div>
                                    <p className="text-sm font-medium text-slate-500 dark:text-slate-400">Global Avg Inflation</p>
                                    <h3 className="text-3xl font-bold text-slate-800 dark:text-white mt-2">
                                        {stats.average_inflation}%
                                    </h3>
                                </div>
                                <div className="p-3 bg-indigo-50 dark:bg-indigo-500/10 rounded-xl text-indigo-600 dark:text-indigo-400">
                                    <Activity className="w-6 h-6" />
                                </div>
                            </div>
                            <div className="mt-4 flex items-center text-sm">
                                <span className="text-amber-500 flex items-center font-medium">
                                    Risk Score: {stats.average_inflation_score}
                                </span>
                            </div>
                        </div>

                        {/* KPI 3 */}
                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm transition-all hover:shadow-md">
                            <div className="flex justify-between items-start">
                                <div>
                                    <p className="text-sm font-medium text-slate-500 dark:text-slate-400">Port Congestion</p>
                                    <h3 className="text-3xl font-bold text-slate-800 dark:text-white mt-2">
                                        {stats.port_congestion_score}%
                                    </h3>
                                </div>
                                <div className="p-3 bg-orange-50 dark:bg-orange-500/10 rounded-xl text-orange-600 dark:text-orange-400">
                                    <Ship className="w-6 h-6" />
                                </div>
                            </div>
                            <div className="mt-4 flex items-center text-sm text-slate-500 dark:text-slate-400">
                                <span>{stats.congested_ports} of {stats.total_ports} ports affected</span>
                            </div>
                        </div>

                        {/* KPI 4 */}
                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm transition-all hover:shadow-md">
                            <div className="flex justify-between items-start">
                                <div>
                                    <p className="text-sm font-medium text-slate-500 dark:text-slate-400">High Risk Countries</p>
                                    <h3 className="text-3xl font-bold text-slate-800 dark:text-white mt-2">
                                        {stats.high_risk}
                                    </h3>
                                </div>
                                <div className="p-3 bg-red-50 dark:bg-red-500/10 rounded-xl text-red-600 dark:text-red-400">
                                    <AlertTriangle className="w-6 h-6" />
                                </div>
                            </div>
                            <div className="mt-4 flex items-center text-sm text-slate-500 dark:text-slate-400">
                                <span>Out of {stats.total_countries} monitored zones</span>
                            </div>
                        </div>

                    </div>

                    {/* Main Content Area */}
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        
                        {/* Risk Chart */}
                        <div className="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <div className="flex justify-between items-center mb-6">
                                <h3 className="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                                    <TrendingUp className="w-5 h-5 text-indigo-500" />
                                    Composite Risk Scores by Country
                                </h3>
                            </div>
                            <div className="h-[350px] w-full">
                                <ResponsiveContainer width="100%" height="100%">
                                    <BarChart data={riskChartData} margin={{ top: 20, right: 30, left: 0, bottom: 5 }}>
                                        <CartesianGrid strokeDasharray="3 3" vertical={false} stroke="#334155" opacity={0.2} />
                                        <XAxis dataKey="name" axisLine={false} tickLine={false} tick={{fill: '#64748b'}} />
                                        <YAxis axisLine={false} tickLine={false} tick={{fill: '#64748b'}} />
                                        <RechartsTooltip 
                                            cursor={{fill: 'transparent'}}
                                            contentStyle={{borderRadius: '12px', border: 'none', boxShadow: '0 4px 6px -1px rgb(0 0 0 / 0.1)'}}
                                        />
                                        <Bar dataKey="score" radius={[6, 6, 0, 0]}>
                                            {riskChartData.map((entry, index) => (
                                                <Cell key={`cell-${index}`} fill={getRiskColor(entry.score)} />
                                            ))}
                                        </Bar>
                                    </BarChart>
                                </ResponsiveContainer>
                            </div>
                        </div>

                        {/* Recent News Intelligence */}
                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm flex flex-col">
                            <div className="flex justify-between items-center mb-6">
                                <h3 className="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                                    <Newspaper className="w-5 h-5 text-blue-500" />
                                    Intelligence Feed
                                </h3>
                            </div>
                            <div className="flex-1 overflow-y-auto pr-2 space-y-4">
                                {recentNews.length === 0 ? (
                                    <p className="text-slate-500 dark:text-slate-400 text-sm text-center py-8">No recent intelligence available.</p>
                                ) : (
                                    recentNews.map((news) => (
                                        <a key={news.id} href={news.url} target="_blank" rel="noreferrer" className="block group">
                                            <div className="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30 border border-transparent group-hover:border-slate-200 dark:group-hover:border-slate-600 transition-all">
                                                <div className="flex items-center gap-2 mb-2">
                                                    <span className="text-xs font-semibold px-2 py-1 rounded bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">
                                                        {news.country?.name || 'Global'}
                                                    </span>
                                                    <span className="text-xs text-slate-500 dark:text-slate-400">
                                                        {new Date(news.published_at).toLocaleDateString()}
                                                    </span>
                                                </div>
                                                <h4 className="text-sm font-semibold text-slate-800 dark:text-slate-200 line-clamp-2 group-hover:text-blue-500 transition-colors">
                                                    {news.title}
                                                </h4>
                                                <div className="mt-2 text-xs flex items-center justify-between">
                                                    <span className="text-slate-500">{news.source}</span>
                                                    <span className={`font-medium ${
                                                        news.sentiment === 'negative' ? 'text-red-500' :
                                                        news.sentiment === 'positive' ? 'text-emerald-500' : 'text-slate-500'
                                                    }`}>
                                                        {news.sentiment ? news.sentiment.toUpperCase() : 'UNKNOWN'}
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    ))
                                )}
                            </div>
                        </div>

                    </div>

                    {/* Country Details Table */}
                    <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
                        <div className="flex justify-between items-center mb-6">
                            <h3 className="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                                <Globe className="w-5 h-5 text-emerald-500" />
                                Country Monitor
                            </h3>
                        </div>
                        <div className="overflow-x-auto">
                            <table className="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                                <thead className="bg-slate-50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700">
                                    <tr>
                                        <th className="px-4 py-3 font-semibold rounded-tl-xl">Country</th>
                                        <th className="px-4 py-3 font-semibold">GDP</th>
                                        <th className="px-4 py-3 font-semibold">Inflation</th>
                                        <th className="px-4 py-3 font-semibold">Currency Rate</th>
                                        <th className="px-4 py-3 font-semibold">Weather</th>
                                        <th className="px-4 py-3 font-semibold rounded-tr-xl">Risk Status</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-slate-100 dark:divide-slate-700/50">
                                    {countries.map(country => (
                                        <tr key={country.id} className="hover:bg-slate-50/50 dark:hover:bg-slate-700/10 transition-colors">
                                            <td className="px-4 py-4">
                                                <div className="flex items-center gap-3">
                                                    <img src={country.flag} alt={country.name} className="w-8 h-6 rounded object-cover shadow-sm" />
                                                    <div>
                                                        <div className="font-semibold text-slate-800 dark:text-slate-200">{country.name}</div>
                                                        <div className="text-xs text-slate-500">{country.code}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="px-4 py-4 font-medium">${formatNumber(country.gdp)}</td>
                                            <td className="px-4 py-4">
                                                <span className={`px-2 py-1 rounded text-xs font-medium ${
                                                    country.inflation > 5 ? 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400'
                                                }`}>
                                                    {country.inflation}%
                                                </span>
                                            </td>
                                            <td className="px-4 py-4">
                                                {country.exchangeRate ? (
                                                    <div>
                                                        <div>{country.exchangeRate.rate} {country.exchangeRate.currency}</div>
                                                        <div className="text-xs text-slate-500">per USD</div>
                                                    </div>
                                                ) : <span className="text-slate-400">N/A</span>}
                                            </td>
                                            <td className="px-4 py-4">
                                                {country.weather ? (
                                                    <div className="flex items-center gap-2">
                                                        <Wind className="w-4 h-4 text-slate-400" />
                                                        <span className="capitalize">{country.weather.condition}</span>
                                                        <span className="text-xs text-slate-500 ml-1">({country.weather.temperature}°C)</span>
                                                    </div>
                                                ) : <span className="text-slate-400">N/A</span>}
                                            </td>
                                            <td className="px-4 py-4">
                                                {country.riskScore ? (
                                                    <div className={`px-3 py-1.5 rounded-lg inline-flex items-center gap-1.5 text-xs font-bold border ${getRiskBgColor(country.riskScore.status)}`}>
                                                        <div className="w-1.5 h-1.5 rounded-full bg-current opacity-70"></div>
                                                        {country.riskScore.status.toUpperCase()}
                                                    </div>
                                                ) : <span className="text-slate-400">Unknown</span>}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
