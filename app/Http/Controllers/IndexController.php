<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class IndexController extends Controller
{
    public function __invoke(Request $request) {

        $articles = Article::paginate(10);
        return view('index')
                ->with('articles', $articles);
    }
}
