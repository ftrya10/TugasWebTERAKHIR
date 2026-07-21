import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, router } from '@inertiajs/react';
import { useState } from 'react';
import { Newspaper, Plus, Pencil, Trash2, X, Save, Calendar, User } from 'lucide-react';

export default function Index({ auth, articles }) {
    const [showForm, setShowForm] = useState(false);
    const [editingId, setEditingId] = useState(null);

    const { data, setData, post, put, processing, reset, errors } = useForm({
        title: '',
        content: '',
        category: '',
    });

    const categories = ['Ekonomi', 'Risiko Cuaca', 'Analisis Komparatif', 'Geopolitik', 'Teknologi', 'Mata Uang', 'Metodologi', 'Negara'];

    const handleSubmit = (e) => {
        e.preventDefault();
        if (editingId) {
            put(route('admin.articles.update', editingId), {
                onSuccess: () => { reset(); setEditingId(null); setShowForm(false); }
            });
        } else {
            post(route('admin.articles.store'), {
                onSuccess: () => { reset(); setShowForm(false); }
            });
        }
    };

    const handleEdit = (article) => {
        setData({ title: article.title, content: article.content, category: article.category || '' });
        setEditingId(article.id);
        setShowForm(true);
    };

    const handleDelete = (id) => {
        if (confirm('Yakin ingin menghapus artikel ini?')) {
            router.delete(route('admin.articles.destroy', id));
        }
    };

    const handleCancel = () => {
        reset();
        setEditingId(null);
        setShowForm(false);
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <Newspaper className="w-6 h-6 text-indigo-500" />
                        <h2 className="text-2xl font-bold leading-tight tracking-tight text-slate-900 dark:text-white">
                            Kelola Artikel Analisis
                        </h2>
                    </div>
                    {!showForm && (
                        <button
                            onClick={() => setShowForm(true)}
                            className="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition-colors"
                        >
                            <Plus className="w-4 h-4" />
                            Tambah Artikel
                        </button>
                    )}
                </div>
            }
        >
            <Head title="Admin - Kelola Artikel" />

            <div className="py-8 bg-slate-50 dark:bg-slate-900 min-h-screen">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

                    {/* Form */}
                    {showForm && (
                        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <div className="flex items-center justify-between mb-6">
                                <h3 className="text-lg font-bold text-slate-800 dark:text-white">
                                    {editingId ? 'Edit Artikel' : 'Tambah Artikel Baru'}
                                </h3>
                                <button onClick={handleCancel} className="p-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                                    <X className="w-5 h-5 text-slate-500" />
                                </button>
                            </div>

                            <form onSubmit={handleSubmit} className="space-y-4">
                                <div>
                                    <label className="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1.5">Judul Artikel</label>
                                    <input
                                        type="text"
                                        value={data.title}
                                        onChange={e => setData('title', e.target.value)}
                                        className="w-full border border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Masukkan judul artikel..."
                                    />
                                    {errors.title && <p className="text-red-500 text-xs mt-1">{errors.title}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1.5">Kategori</label>
                                    <select
                                        value={data.category}
                                        onChange={e => setData('category', e.target.value)}
                                        className="w-full border border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    >
                                        <option value="">-- Pilih Kategori --</option>
                                        {categories.map(cat => (
                                            <option key={cat} value={cat}>{cat}</option>
                                        ))}
                                    </select>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1.5">Konten Artikel</label>
                                    <textarea
                                        value={data.content}
                                        onChange={e => setData('content', e.target.value)}
                                        rows={10}
                                        className="w-full border border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono text-sm"
                                        placeholder="Tulis konten artikel di sini..."
                                    />
                                    {errors.content && <p className="text-red-500 text-xs mt-1">{errors.content}</p>}
                                </div>

                                <div className="flex justify-end gap-3 pt-2">
                                    <button
                                        type="button"
                                        onClick={handleCancel}
                                        className="px-5 py-2.5 border border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-400 rounded-xl font-medium hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors"
                                    >
                                        Batal
                                    </button>
                                    <button
                                        type="submit"
                                        disabled={processing}
                                        className="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition-colors disabled:opacity-50"
                                    >
                                        <Save className="w-4 h-4" />
                                        {editingId ? 'Simpan Perubahan' : 'Publikasikan'}
                                    </button>
                                </div>
                            </form>
                        </div>
                    )}

                    {/* Articles Table */}
                    <div className="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
                        <div className="p-6 border-b border-slate-100 dark:border-slate-700">
                            <h3 className="text-lg font-bold text-slate-800 dark:text-white">
                                Daftar Artikel ({articles.length})
                            </h3>
                        </div>

                        {articles.length === 0 ? (
                            <div className="p-12 text-center">
                                <Newspaper className="w-12 h-12 text-slate-300 dark:text-slate-600 mx-auto mb-3" />
                                <p className="text-slate-500 dark:text-slate-400">Belum ada artikel. Klik "Tambah Artikel" untuk memulai.</p>
                            </div>
                        ) : (
                            <div className="overflow-x-auto">
                                <table className="w-full text-left text-sm">
                                    <thead className="bg-slate-50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700">
                                        <tr>
                                            <th className="px-6 py-3 font-semibold">#</th>
                                            <th className="px-6 py-3 font-semibold">Judul</th>
                                            <th className="px-6 py-3 font-semibold">Kategori</th>
                                            <th className="px-6 py-3 font-semibold">Author</th>
                                            <th className="px-6 py-3 font-semibold">Tanggal</th>
                                            <th className="px-6 py-3 font-semibold text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-slate-100 dark:divide-slate-700/50">
                                        {articles.map((article, idx) => (
                                            <tr key={article.id} className="hover:bg-slate-50/50 dark:hover:bg-slate-700/10 transition-colors">
                                                <td className="px-6 py-4 text-slate-500">{idx + 1}</td>
                                                <td className="px-6 py-4">
                                                    <div className="font-semibold text-slate-800 dark:text-white line-clamp-1">{article.title}</div>
                                                    <div className="text-xs text-slate-500 line-clamp-1 mt-0.5">{article.content.substring(0, 80)}...</div>
                                                </td>
                                                <td className="px-6 py-4">
                                                    {article.category && (
                                                        <span className="px-2.5 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg text-xs font-medium">
                                                            {article.category}
                                                        </span>
                                                    )}
                                                </td>
                                                <td className="px-6 py-4 text-slate-600 dark:text-slate-400">
                                                    <span className="flex items-center gap-1.5">
                                                        <User className="w-3.5 h-3.5" />
                                                        {article.user?.name || 'Admin'}
                                                    </span>
                                                </td>
                                                <td className="px-6 py-4 text-slate-500 text-xs">
                                                    <span className="flex items-center gap-1.5">
                                                        <Calendar className="w-3.5 h-3.5" />
                                                        {new Date(article.created_at).toLocaleDateString('id-ID')}
                                                    </span>
                                                </td>
                                                <td className="px-6 py-4 text-right">
                                                    <div className="flex items-center justify-end gap-2">
                                                        <button
                                                            onClick={() => handleEdit(article)}
                                                            className="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                                                            title="Edit"
                                                        >
                                                            <Pencil className="w-4 h-4" />
                                                        </button>
                                                        <button
                                                            onClick={() => handleDelete(article.id)}
                                                            className="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                                            title="Hapus"
                                                        >
                                                            <Trash2 className="w-4 h-4" />
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        )}
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
