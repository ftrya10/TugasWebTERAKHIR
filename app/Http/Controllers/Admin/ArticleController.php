<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Admin/Articles/Index', [
            'articles' => $articles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'category' => 'nullable|string|max:100',
        ]);

        Article::create([
            'user_id'  => auth()->id(),
            'title'    => $request->title,
            'content'  => $request->content,
            'category' => $request->category,
        ]);

        return redirect()->back()->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'category' => 'nullable|string|max:100',
        ]);

        $article->update($request->only('title', 'content', 'category'));

        return redirect()->back()->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->back()->with('success', 'Artikel berhasil dihapus.');
    }
}
