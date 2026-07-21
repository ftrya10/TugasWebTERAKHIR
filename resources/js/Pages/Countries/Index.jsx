import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { Globe, Search, ArrowRight } from 'lucide-react';

export default function Index({ auth, countries }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="text-xl font-semibold leading-tight text-slate-800 dark:text-slate-200">Country Intelligence</h2>}
        >
            <Head title="Countries" />

            <div className="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                    <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                        <div className="flex justify-between items-center mb-6">
                            <h3 className="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                                <Globe className="w-5 h-5 text-indigo-500" />
                                Monitored Countries
                            </h3>
                            <div className="relative">
                                <Search className="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                                <input type="text" placeholder="Search country..." className="pl-9 pr-4 py-2 border border-slate-200 dark:border-slate-600 rounded-lg text-sm bg-slate-50 dark:bg-slate-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                            </div>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            {countries.map(country => (
                                <Link key={country.id} href={route('countries.show', country.id)} className="block group">
                                    <div className="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-indigo-500 dark:hover:border-indigo-500 hover:shadow-md transition-all">
                                        <div className="flex items-center justify-between mb-3">
                                            <div className="flex items-center gap-3">
                                                <img src={country.flag} alt={country.name} className="w-10 h-7 rounded object-cover shadow-sm" />
                                                <div>
                                                    <h4 className="font-semibold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{country.name}</h4>
                                                    <p className="text-xs text-slate-500">{country.region}</p>
                                                </div>
                                            </div>
                                            <ArrowRight className="w-4 h-4 text-slate-300 group-hover:text-indigo-500 transition-colors -translate-x-2 group-hover:translate-x-0" />
                                        </div>
                                        <div className="flex items-center gap-4 text-sm text-slate-600 dark:text-slate-400">
                                            <div>
                                                <span className="font-medium text-slate-800 dark:text-slate-200">{country.inflation}%</span>
                                                <span className="text-xs ml-1">Inflation</span>
                                            </div>
                                            <div>
                                                <span className="font-medium text-slate-800 dark:text-slate-200">
                                                    {country.riskScore?.status || 'Unknown'}
                                                </span>
                                                <span className="text-xs ml-1">Risk</span>
                                            </div>
                                        </div>
                                    </div>
                                </Link>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
