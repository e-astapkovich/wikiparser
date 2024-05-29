<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class ParserService
{
    private $endpoint = 'https://ru.wikipedia.org/w/api.php';
    private $queryParams =
    [
        "action" => "query",
        "format" => "json",
        "prop" => "extracts",
        "formatversion" => "2",
        "explaintext" => 1,
        "exsectionformat" => "plain"
        // "titles" => "Pet_door",
    ];

    public function setSearchString(string $searchString)
    {
        $this->queryParams["titles"] = $searchString;
        return $this;
    }

    //TODO удалять из текста "\t\t\t\n" (картинки в статье https://en.wikipedia.org/wiki/Door)
    public function handle() {
        $response = Http::withQueryParameters($this->queryParams)->get($this->endpoint);
        $result = $response->json('query.pages.0.extract');
        dd($result);
    }
}

// Http::retry(3, 100)->withQueryParameters([
//     'name' => 'Taylor',
//     'page' => 1,
// ])->get('http://example.com/users')
