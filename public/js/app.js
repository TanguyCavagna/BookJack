$(document).ready(() => {
    registerSW();

    Notification.requestPermission((status) => { });

    $('#test').click(() => {
        showNotification();
    });

    $('.alert').delay(2000).fadeOut(3000);

    $('#search').click(search);
    $('#lucky-day').click(lucky);
});

/**
 * Enregister le `service worker` pour l'application
 */
async function registerSW() {
    if ('serviceWorker' in navigator) {
        try {
            await navigator.serviceWorker.register('./js/sw.js');
        } catch (e) {
            console.log(`SW registration failed`);
        }
    }
}

/**
 * Recherche sur les différentes API la requête de l'utilisateur
 * @param {*} event 
 */
function search(event) {
    if (event) {
        event.preventDefault();
    }

    $('#results').empty();

    let searchTerms = $('#search-terms').val();
    let searchType = $('#search-type').val();

    if (searchTerms.length == 0)
        return;

    switch (searchType) {
        case 'manga':
            let jikan = new JikanJS();

            jikan.getSearchResults(searchTerms, 'manga', 1)
            .catch((error) => {  })
            .then((data) => {
                data.results.forEach((result) => {
                    jikan.getMangaById(result.mal_id)
                    .catch((error) => {  })
                    .then((final) => {
                        showSearchResults(final);
                    });
                });
            });
            break;
        case 'novel':
            break;
        case 'comic':
            break;
        default:
            break;
    }
}

/**
 * Récupère un livre aléatoire en fonction du type de libre choisis
 * @param {*} event 
 */
function lucky(event) {
    if (event) {
        event.preventDefault();
    }

    $('#results').empty();

    let searchType = $('#search-type').val();

    switch (searchType) {
        case 'manga':
            let jikan = new JikanJS();

            jikan.getRandomManga()
            .catch((error) => {  })
            .then((data) => {
                showSearchResults(data);
            });
            break;
        case 'novel':
            break;
        case 'comic':
            break;
        default:
            break;
    }
}

/**
 * Affiche les résultats obtenu
 * @param {array} results
 */
function showSearchResults(result) {
    if (typeof result === 'undefined') {
        return;
    }

    if (result.hasOwnProperty('errorNo')) {
        return;
    }

    let date = "Unknown";
    
    if (result.hasOwnProperty('published')) {
        let from = result.published.from;

        if (from != null) {
            date = formatDate(from);
        }
    } else if (result.hasOwnProperty('publishing')) {
        let start = result.start_date;

        if (start != null) {
            date = formatDate(start);
        }
    }

    let genresStr = "";
    if (result.hasOwnProperty('genres')) {
        let genres = result.genres;
        
        genres.forEach((genre) => {
            if (genre.name == "Hentai") {
                return;
            }
            genresStr += genre.name + ", ";
        });
        
        genresStr = genresStr.slice(0, -2);
    } else {
        genresStr = "Unknown";
    }

    let element = `
    <div class="result p-3 xl:w-1/3 lg:w-2/4 md:w-2/4 sm:w-full flex">
        <div class="result-image h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('${result.image_url}')">
        </div>
        <div class="title h-auto absolute ml-3 mb-3 p-3 text-white font-semibold">${result.title}</div>
        <div class="result-info-container bg-white rounded-b lg:rounded-b-none lg:rounded-r flex flex-col leading-normal p-0 w-full">
            <div class="result-info p-0 m-0 h-full w-full">
                <div class="season h-8 text-white font-semibold text-center flex flex-col justify-around">
                    ${date}
                </div>

                <div class="synopsis bg-white text-black text-sm pl-2 pr-2">
                    ${result.synopsis}
                </div>

                <div class="genres text-white text-center flex flex-col justify-around pl-1 pr-1">
                    ${genresStr}
                </div>
            </div>
        </div>
    </div>
    `;

    $('#results').append(element);
}

/**
 * Formate la date
 * @param {string} timestamp Date
 */
function formatDate(timestamp) {
    let ts = new Date(timestamp);

    let year = ts.getFullYear();
    let month = monthToString(ts.getMonth());
    let day = ts.getDate();

    return month + " " + day + ", " + year;
}

/**
 * Converti un mois 01-12 en abréviation
 * @param {int} month Mois entre 01 et 12
 */
function monthToString(month) {
    let chr = [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Sep', 'Oct', 'Nov', 'Dec' ];

    return chr[month];
}