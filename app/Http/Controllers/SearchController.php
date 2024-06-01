<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Atom;

class SearchController extends Controller
{
    public function __invoke(Request $request) {
        $searchString = $request->input('search');

        $atom = Atom::where('word', $searchString)->first();

        if (!$atom) {
            return response()->json([
                'status' => 'не найдено'
            ]);
        }

        $articles = $atom->articles()->get();

        return response()->json($articles);
    }
}
