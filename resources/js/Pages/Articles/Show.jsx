import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { ArrowLeft, Calendar, User, Tag } from 'lucide-react';

export default function Show({ auth, article }) {
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

    // Simple markdown-like rendering for content
    const renderContent = (text) => {
        return text.split('\n').map((line, i) => {
            // Bold
            line = line.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            // Code blocks
            line = line.replace(/```(.*?)```/g, '<code class="bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded text-sm">$1</code>');
            // Inline code
            line = line.replace(/`(.*?)`/g, '<code class="bg-slate-100 dark:bg-slate-700 px-1.5 py-0.5 rounded text-sm font-mono">$1</code>');

            if (line.startsWith('- ')) {
                return <li key={i} className="ml-4 list-disc text-slate-700 dark:text-slate-300" dangerouslySetInnerHTML={{ __html: line.substring(2) }} />;
            }
            if (/^\d+\.\s/.test(line)) {
                return <li key={i} className="ml-4 list-decimal text-slate-700 dark:text-slate-300" dangerouslySetInnerHTML={{ __html: line.replace(/^\d+\.\s/, '') }} />;
            }
            if (line.trim() === '') {
                return <br key={i} />;
            }
            return <p key={i} className="text-slate-700 dark:text-slate-300 leading-relaxed" dangerouslySetInnerHTML={{ __html: line }} />;
        });
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center gap-4">
                    <Link href={route('articles.index')} className="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        <ArrowLeft className="w-5 h-5 text-slate-600 dark:text-slate-300" />
                    </Link>
                    <h2 className="text-xl font-bold leading-tight text-slate-900 dark:text-white line-clamp-1">
                        {article.title}
                    </h2>
                </div>
            }
        >
            <Head title={article.title} />

            <div className="py-8 bg-slate-50 dark:bg-slate-900 min-h-screen">
                <div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-slate-800 rounded-2xl p-8 md:p-12 border border-slate-100 dark:border-slate-700 shadow-sm">

                        {/* Article Header */}
                        <div className="mb-8 pb-6 border-b border-slate-100 dark:border-slate-700">
                            {article.category && (
                                <span className={`inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold mb-4 ${getCategoryColor(article.category)}`}>
                                    <Tag className="w-3 h-3" />
                                    {article.category}
                                </span>
                            )}
                            <h1 className="text-3xl font-extrabold text-slate-900 dark:text-white mt-3 leading-tight">
                                {article.title}
                            </h1>
                            <div className="flex items-center gap-4 mt-4 text-sm text-slate-500 dark:text-slate-400">
                                <span className="flex items-center gap-1.5">
                                    <User className="w-4 h-4" />
                                    {article.user?.name || 'Admin'}
                                </span>
                                <span className="flex items-center gap-1.5">
                                    <Calendar className="w-4 h-4" />
                                    {new Date(article.created_at).toLocaleDateString('id-ID', {
                                        weekday: 'long',
                                        day: 'numeric',
                                        month: 'long',
                                        year: 'numeric'
                                    })}
                                </span>
                            </div>
                        </div>

                        {/* Article Content */}
                        <div className="prose prose-slate dark:prose-invert max-w-none space-y-2">
                            {renderContent(article.content)}
                        </div>

                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
