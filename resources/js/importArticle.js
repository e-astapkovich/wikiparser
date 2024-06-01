let importForm = document.getElementById('importForm');
let importInfo = document.getElementById('importInfo');
let importUrl = document.getElementById('importUrl');
let importTime = document.getElementById('importTime');
let importSize = document.getElementById('importSize');
let importWords = document.getElementById('importWords');
let articlesTable = document.getElementById('articlesTable');


importForm.onsubmit = async (event) => {
    event.preventDefault();

    let response = await fetch('/import', {
        method: 'POST',
        body: new FormData(importForm)
    });

    // TODO Добавить спиннер на время загрузки статьи.

    let result = await response.json();

    console.log(result);

    let htmlString = '';

    htmlString += `<p class="mt-0 mb-2"><span id="importStatus">${result.status}</span></p>`

    if (result.status == 'Импорт завершен') {
        htmlString += `
        <p class="m-0"><span id="importUrl">Найдена статья по адресу: </span><span id="search-url">https://ru.wikipedia.org/wiki/${result.article.title}</span></p>
        <p class="m-0"><span id="importTime">Время обработки: </span><span id="search-time">.....</span></p>
        <p class="m-0"><span id="importSize">Размер статьи: </span><span id="search-size">.....</span></p>
        <p class="m-0"><span id="importWords">Количество слов: </span><span id="search-words">.....</span></p>
        `;

        let article = document.createElement('tr');
        article.innerHTML = `
        <th scope="row">${ result.article.id }</th>
        <td>${ result.article.title }</td>
        <td><a href="https://ru.wikipedia.org/wiki/${ result.article.title }" target="_blank">https://ru.wikipedia.org/wiki/${ result.article.title }</a></td>
        <td>.....</td>
        <td>.....</td>
        `

        articlesTable.append(article);
    }

    importInfo.innerHTML = htmlString;
};
