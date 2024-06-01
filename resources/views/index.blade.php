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
                    <form method="post" action="" id="import-form" enctype="multipart/form-data" class="d-flex gap-2 mb-3">
                        @csrf
                        <input type="text" name=search class="form-control w-75" placeholder="Ключевое слово">
                        <input type="submit" class="btn btn-secondary" value="Скопировать">
                    </form>
                    <div class="mb-4 p-3 border rounded">
                        <p class="mt-0 mb-2"><span>Импорт завершен</span></p>
                        <p class="m-0"><span>Найдена статья по адресу: </span><span id="search-url"></span></p>
                        <p class="m-0"><span>Время обработки: </span><span id="search-time">0,34</span></p>
                        <p class="m-0"><span>Размер статьи: </span><span id="search-size">35</span></p>
                        <p class="m-0"><span>Количество слов: </span><span id="search-words">1236</span></p>
                    </div>
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
                        <tbody>
                            @forelse ($articles as $article)
                            <tr>
                                <th scope="row">{{ $article->id }}</th>
                                <td>{{ $article->title }}</td>
                                <td><a href="https://ru.wikipedia.org/wiki/{{ $article->title }}" target="_blank">https://ru.wikipedia.org/wiki/{{ $article->title }}</a></td>
                                <td>123</td>
                                <td>1111</td>
                            </tr>
                            @empty
                                'пусто'
                            @endforelse
                        </tbody>
                    </table>
                    {{ $articles->links() }}
                </div>
            </div>
            <div class="search-tab p-4 tab-pane fade" id="profile-tab-pane" role="tabpanel"
                aria-labelledby="profile-tab" tabindex="0">
                <div class="mb-2 search-tab__form">
                    <form method="post" action="" id="search-form" enctype="multipart/form-data" class="d-flex gap-2 mb-3">
                        <input type="text" class="form-control w-75" placeholder="Ключевое слово">
                        <input type="submit" class="btn btn-secondary" value="Найти">
                    </form>
                </div>
                <hr>
                <div class="search-tab__results d-flex justify-content-between">
                    <div class="search-tab__content flex-grow-1">
                        <p class="search-tab__meta">Найдено: <span id="search-results-qty">10</span></p>
                        <ul class="search-tab__list list-unstyled">
                            <li class="search-tab__item">
                                <span class="search-result-title">item-1 </span>
                                (<span class="search-result-includes">11</span> вхождений)
                            </li>
                            <li class="search-tab__item">
                                <span class="search-result-title">item-2 </span>
                                (<span class="search-result-includes">12</span> вхождений)
                            </li>
                            <li class="search-tab__item">
                                <span class="search-result-title">item-3 </span>
                                (<span class="search-result-includes">100</span> вхождений)
                            </li>
                        </ul>
                    </div>
                    <div class="search-tab__article w-50 p-3 border rounded">
                        <h4>title</h4>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti aspernatur vel nobis
                        perspiciatis
                        quas, omnis laudantium aperiam error sint quidem ullam, aliquam corrupti fugiat quibusdam
                        laborum
                        sunt similique, enim facilis quo nam consequatur molestias? Suscipit vero aspernatur ipsam
                        dolorem
                        iusto deleniti, doloremque dolore reprehenderit fugit autem non, omnis, minus quisquam adipisci
                        in
                        voluptas?
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
