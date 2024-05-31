<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

// TODO реализовать функционал поиска статей.
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
