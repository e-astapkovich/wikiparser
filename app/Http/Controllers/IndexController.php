<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Article;

class IndexController extends Controller
{
    /**
     * Метод, возвращающий html-страницу сервиса
     * Извлекает из БД статьи, с дополнительной колонкой с количеством слов в статье
     */
    public function __invoke() {

        // $articles = Article::all();

        $articles = DB::table('articles')
            ->leftJoin('indexes', 'indexes.article_id', '=', 'articles.id')
            ->select(DB::raw('articles.*, sum(quantity) as words_quantity'))
            ->groupBy('articles.title')
            ->get();

        return view('index')
            ->with('articles', $articles);
    }
}
