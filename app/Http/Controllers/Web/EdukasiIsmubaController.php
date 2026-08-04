<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ArtikelIsmuba;
use Illuminate\View\View;

class EdukasiIsmubaController extends Controller
{
    /**
     * Display a listing of Edukasi ISMUBA articles.
     */
    public function index(): View
    {
        $articles = ArtikelIsmuba::latest()->paginate(9);

        return view('ismuba.index', compact('articles'));
    }

    /**
     * Display the specified article.
     */
    public function show(ArtikelIsmuba $article): View
    {
        $relatedArticles = ArtikelIsmuba::where('id', '!=', $article->id)
            ->where('kategori', $article->kategori)
            ->take(3)
            ->get();

        if ($relatedArticles->isEmpty()) {
            $relatedArticles = ArtikelIsmuba::where('id', '!=', $article->id)->take(3)->get();
        }

        return view('ismuba.show', compact('article', 'relatedArticles'));
    }
}
