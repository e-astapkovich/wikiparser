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

        $inputString = $request->input('title');

        $result = $parser->setSearchString($inputString)->handle();

        return response()->json($result);
    }
}
