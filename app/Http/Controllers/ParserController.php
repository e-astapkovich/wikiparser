<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\ParserService;
use App\Http\Services\AtomizeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ParserController extends Controller
{
    public function __invoke(Request $request, ParserService $parser) {

        $searchString = $request->input('search');
        // $searchString = 'Челябинск';

        // TODO Добавить проверку - существет ли в БД статья с таким названием.

        $result = $parser->setSearchString($searchString)->handle();
        return $result;
    }
}
