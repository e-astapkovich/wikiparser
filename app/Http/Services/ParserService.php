<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Models\Article;
use App\Models\Atom;
use App\Models\IndexModel;

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
            return ['status' => 'Статья с таким названием не найдена в Википедии'];
        }

        $article = Article::firstOrCreate(
            ['title' => $this->queryParams['titles']],
            ['content' => $content]
        );

        if($article->wasRecentlyCreated) {
            $atoms = $this->atomize($content);
            $this->saveAtomsAndIndex($atoms, $article->id);
        }

        return [
            'status' => $article->wasRecentlyCreated? 'Импорт завершен' : 'Статья уже была импортирована ранее',
            'article' => $article
        ];
    }

    public function atomize(string $text) {

        $atoms = [];
        $pattern = '/[a-zA-zа-яА-ЯёЁ0-9]+/u';

        preg_match_all(
            $pattern,
            $text,
            $atoms,
        );

        $atoms = $atoms[0];

        $loweredAtoms = Arr::map($atoms, function (string $value, string $key) {
            return Str::lower($value);
        });

        $atoms = array_count_values($loweredAtoms);

        return $atoms;
    }

    public function saveAtomsAndIndex(array $atoms, int $articleId) {
        foreach ($atoms as $word => $quantity) {
            $atom = Atom::firstOrCreate(['word' => $word]);

            $idx = new IndexModel();
            $idx->atom_id = $atom->id;
            $idx->article_id = $articleId;
            $idx->quantity = $quantity;

            $idx->save();
        }
    }
}
