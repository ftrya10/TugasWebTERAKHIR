import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { Newspaper, Calendar, User, Tag, ArrowRight } from 'lucide-react';

export default function Index({ auth, articles }) {
    const getCategoryColor = (category) => {
        const map = {
            'Ekonomi': 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
            'Risiko Cuaca': 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
            'Analisis Komparatif': 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300',
            'Geopolitik': 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
            'Teknologi': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
            'Mata Uang': 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300',
            'Metodologi': 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
            'Negara': 'bg-teal-100 text-teal-700 dark:bg-teal-900/40 dark:text-teal-300',
        };
        return map[category] || 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300';
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center gap-3">
                    <Newspaper className="w-6 h-6 text-indigo-500" />
                    <h2 className="text-2xl font-bold leading-tight tracking-tight text-slate-900 dark:text-white">
                        Supply Chain Intelligence Articles
                    </h2>
                </div>
            }
        >
            <Head title="Articles" />

            <div className="py-8 bg-slate-50 dark:bg-slate-900 min-h-screen">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">

                    {articles.length === 0 ? (
                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-12 border border-slate-100 dark:border-slate-700 text-center">
                            <Newspaper className="w-16 h-16 text-slate-300 dark:text-slate-600 mx-auto mb-4" />
                            <h3 className="text-xl font-semibold text-slate-600 dark:text-slate-400">Belum ada artikel</h3>
                            <p className="text-sm text-slate-500 mt-2">Admin belum mempublikasikan artikel analisis.</p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {articles.map(article => (
                                <Link
                                    key={article.id}
                                    href={route('articles.show', article.id)}
                                    className="group block"
                                >
                                    <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-lg hover:border-indigo-300 dark:hover:border-indigo-600 transition-all h-full flex flex-col">
                                        {/* Category badge */}
                                        {article.category && (
                                            <div className="mb-3">
                                                <span className={`inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold ${getCategoryColor(article.category)}`}>
                                                    <Tag className="w-3 h-3" />
                                                    {article.category}
                                                </span>
                                            </div>
                                        )}

                                        {/* Title */}
                                        <h3 className="text-lg font-bold text-slate-800 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2 mb-3">
                                            {article.title}
                                        </h3>

                                        {/* Content Preview */}
                                        <p className="text-sm text-slate-600 dark:text-slate-400 line-clamp-3 flex-1 mb-4">
                                            {article.content.replace(/[#*`\n]/g, ' ').substring(0, 200)}...
                                        </p>

                                        {/* Footer */}
                                        <div className="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                                            <div className="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                                                <span className="flex items-center gap-1">
                                                    <User className="w-3 h-3" />
                                                    {article.user?.name || 'Admin'}
                                                </span>
                                                <span className="flex items-center gap-1">
                                                    <Calendar className="w-3 h-3" />
                                                    {new Date(article.created_at).toLocaleDateString('id-ID', {
                                                        day: 'numeric',
                                                        month: 'short',
                                                        year: 'numeric'
                                                    })}
                                                </span>
                                            </div>
                                            <ArrowRight className="w-4 h-4 text-slate-400 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all" />
                                        </div>
                                    </div>
                                </Link>
                            ))}
                        </div>
                    )}

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
