<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_published', true)->latest()->paginate(10);

        return response()->json(['success' => true, 'message' => 'Artikel edukasi kesehatan', 'data' => $articles]);
    }

    public function show(Article $article)
    {
        if (!$article->is_published) {
            abort(404);
        }

        return response()->json(['success' => true, 'data' => $article]);
    }
}
