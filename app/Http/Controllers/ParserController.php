<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\ParserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ParserController extends Controller
{
    public function __invoke(Request $request, ParserService $parser) {

        $searchString = $request->input('search');
        // $searchString = 'Челябинск';

        $parser->setSearchString($searchString)->handle();
    }
}
