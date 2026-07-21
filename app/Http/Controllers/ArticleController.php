<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Inertia\Inertia;

class ArticleController extends Controller
{
    /**
     * Menampilkan daftar artikel analisis untuk user.
     */
    public function index()
    {
        $articles = Article::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Articles/Index', [
            'articles' => $articles,
        ]);
    }

    /**
     * Menampilkan detail artikel.
     */
    public function show(Article $article)
    {
        $article->load('user');

        return Inertia::render('Articles/Show', [
            'article' => $article,
        ]);
    }
}
