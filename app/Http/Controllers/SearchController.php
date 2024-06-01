<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\Atom;

class SearchController extends Controller
{
    public function __invoke(Request $request) {
        $searchString = $request->input('search');

        $articles = DB::table('indexes')
            ->join('atoms', 'atoms.id', '=', 'indexes.atom_id')
            ->join('articles', 'articles.id', '=', 'indexes.article_id')
            ->where('atoms.word', $searchString)
            ->select('articles.*', 'quantity')
            ->orderByDesc('quantity')
            ->get();

        if ($articles->isEmpty()) {
            return response()->json([
                'status' => 'не найдено'
            ]);
        }

        return response()->json($articles);
    }
}
