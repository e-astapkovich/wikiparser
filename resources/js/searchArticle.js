let searchForm = document.getElementById('searchForm');
let searchArticleTitle = document.getElementById('searchArticleTitle');
let searchArticleContent = document.getElementById('searchArticleContent');
let searchResults = document.getElementById('searchResults');
let searchResultsQty = document.getElementById('searchResultsQty');

searchForm.onsubmit = async (event) => {
    event.preventDefault();

    let response = await fetch('/search', {
        method: 'POST',
        body: new FormData(searchForm)
    });

    let result = await response.json();
    console.log(result);

    if (result.status == 'не найдено') {
        searchResults.innerHTML = '';
        searchResultsQty.innerHTML = 0;
    } else {
        let htmlString = '';

        result.forEach(article => {
            htmlString += `
        <li class="search-tab__item">
            <button class="search-result-title bg-transparent border border-0" data-id="${article.id}">${article.title}</button>
            (количество вхождений: <span class="search-result-includes">${article.quantity}</span>)
        </li>
        `;
        });

        searchResults.innerHTML = htmlString;
        searchResultsQty.innerHTML = result.length;

        searchResults.addEventListener('click', (e) => {
            if (e.target.classList.contains('search-result-title')) {
                console.log(e.target.dataset.id);

                let targetArticle = result.find((item) => {
                    return item.id == e.target.dataset.id;
                })

                searchArticleTitle.innerHTML = targetArticle.title;
                searchArticleContent.innerHTML = targetArticle.content;
            }
        });
    }
};
