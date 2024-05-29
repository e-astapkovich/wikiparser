<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ParserService
{
    private $endPoint = "https://en.wikipedia.org/w/api.php";

    private $params = [
    "action" => "opensearch",
    "limit" => "5",
    "namespace" => "0",
    "format" => "json",
    "search" => "Hampi",
];

    public function __construct() {
        // $this->searchParams["search"] = ;
    }

    public function handle() {

    }
}


// Http::retry(3, 100)->withQueryParameters([
//     'name' => 'Taylor',
//     'page' => 1,
// ])->get('http://example.com/users')
