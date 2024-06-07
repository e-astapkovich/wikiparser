<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Models\Article;
use App\Models\Atom;
use App\Models\IndexModel;
use App\Jobs\SaveAtomsAndIndex;

/**
 * Обработчик поискового запроса
 * @param Request $request
 */
class ParserService
{
    /**
	 * URL для API запросов
	 * @var string
	 */
    private $endpoint = 'https://ru.wikipedia.org/w/api.php';

    /**
	 * Массив параметров для исходящего http-запроса на Wiki API
	 * @var array
	 */
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

    /**
     * Добавляет ключевое слово для поиска в массив параметров исходящего http-запроса
     * @param string $searchString
     * @return $this
     */
    public function setSearchString(string $searchString) {
        $this->queryParams["titles"] = $searchString;
        return $this;
    }

    /**
     * Осуществляет парсинг статьи: отправка запроса, сохранение результата в БД, вызов функции, делящей статью на слова-атомы
     * @return array
     */
    public function handle() {
        $result = [];

        $startTime = microtime(true);

        //TODO удалять из текста "\t\t\t\n" (картинки в статье https://en.wikipedia.org/wiki/Door)
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
            $result['atomsCount']  = count($atoms);
            // $this->saveAtomsAndIndex($atoms, $article->id);
            SaveAtomsAndIndex::dispatch($atoms, $article->id);
        }

        $finishTime = microtime(true);
        $executionTime = round($finishTime - $startTime, 2);

        $result = array_merge(
            $result,
            [
                'status' => $article->wasRecentlyCreated? 'Импорт завершен' : 'Статья уже была импортирована ранее',
                'article' => $article,
                'articleSize' => round(strlen($article->content)/1024, 2),
                'executionTime' => $executionTime
            ]
        );

        return $result;
    }

    /**
     * Делит текст на слова-атомы
     * @param string $text
     * @return array
     */
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
}
