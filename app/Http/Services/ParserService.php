<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Article;

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

        // TODO Добавить обработку ошибок
        if ($response->ok()) {
            $content = $response->json('query.pages.0.extract');
        }

        if (!$content) {
            return false;
        }

        $article = Article::firstOrCreate(
            ['title' => $this->queryParams['titles']],
            ['content' => $content]
        );

        return $article->wasRecentlyCreated ? $article : null;
    }
}
