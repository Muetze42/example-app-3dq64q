<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(Request $request): Response
    {
        $articles = Article::query()
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString()
            ->through(fn(Article $article) => [
                'id'      => $article->getKey(),
                'title'   => $article->title,
                'excerpt' => $article->excerpt,
                'thumb'   => $article->getFirstMediaUrl('picture', 'thumb'),
                'image'   => $article->getFirstMediaUrl('picture'),
                'content' => paresMarkdown($article->content),
            ]);

        return Inertia::render('Articles/Index', [
            'articles' => $articles,
        ]);
    }
}
