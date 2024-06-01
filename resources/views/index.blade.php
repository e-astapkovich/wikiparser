<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Application') }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    {{-- TODO Добавить какой нибудь хэдер --}}
    <div class="header mb-3">
    </div>
    <div class="container">
        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="import-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                    type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Импорт статей</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="import-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                    type="button" role="tab" aria-controls="home-tab-pane" aria-selected="false">Поиск</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="import-tab p-4 tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                aria-labelledby="home-tab" tabindex="0">
                <div class="mb-2">
                    <form id="importForm" class="d-flex gap-2 mb-3">
                        @csrf
                        <input type="text" name=title class="form-control w-75" placeholder="Ключевое слово">
                        <input type="submit" class="btn btn-secondary" value="Скопировать">
                    </form>
                    <div id="importInfo" class="mb-4 p-3 border rounded"></div>
                    <hr>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Название статьи</th>
                                <th scope="col">Ссылка</th>
                                <th scope="col">Размер</th>
                                <th scope="col">Количество слов</th>
                            </tr>
                        </thead>
                        <tbody id="articlesTable">
                            @foreach ($articles as $article)
                            <tr>
                                <th scope="row">{{ $article->id }}</th>
                                <td>{{ $article->title }}</td>
                                <td><a href="https://ru.wikipedia.org/wiki/{{ $article->title }}" target="_blank">https://ru.wikipedia.org/wiki/{{ $article->title }}</a></td>
                                <td>.....</td>
                                <td>.....</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $articles->links() }} --}}
                </div>
            </div>
            <div class="search-tab p-4 tab-pane fade" id="profile-tab-pane" role="tabpanel"
                aria-labelledby="profile-tab" tabindex="0">
                <div class="mb-2 search-tab__form">
                    <form id="searchForm"class="d-flex gap-2 mb-3">
                        <input type="text" name="search" class="form-control w-75" placeholder="Ключевое слово">
                        <input type="submit" class="btn btn-secondary" value="Найти">
                    </form>
                </div>
                <hr>
                <div class="search-tab__results d-flex justify-content-between">
                    <div class="search-tab__content flex-grow-1">
                        <p class="search-tab__meta">Найдено совпадений: <span id="searchResultsQty"></span></p>
                        <ul id="searchResults" class="search-tab__list list-unstyled">
                        </ul>
                    </div>
                    <div id="searchArticle" class="search-tab__article w-50 p-3 border rounded">
                        <h4 id="searchArticleTitle"></h4>
                        <div id="searchArticleContent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
