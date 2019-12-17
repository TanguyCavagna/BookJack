/**
 * @author Tanguy Cavagna
 * @file Fichier contenant la classe JikanJS. Créer le 28.10.2019
 * @version 1.1
 * 
 * @classdesc Cette classe permet d'utiliser l'API rest "Jikan.js" avec facilité. Chacune des méthodes retourne le JSON complet
 *            envoyé par "Jikan.js". Tout le parsing doit être fait après le retour des données
 */
class JikanJS {
    /**
     * Constructeur par défaut
     */
    constructor() { }

    /**
     * Retourne sous forme de JSON un anime random
     */
    async getRandomAnime() {
        return await this._computeFetch("https://api.jikan.moe/v3/anime/" + this._getRandomIndex());
    }

    /**
     * Retourne sous forme de JSON un anime random
     */
    async getRandomManga() {
        return await this._computeFetch("https://api.jikan.moe/v3/manga/" + this._getRandomIndex());
    }

    /**
     * Retourne sous forme de JSON les résultats de la recherches
     * @param {string} searchQuery Recherche
     * @param {string} type Type de recherche (anime/manga)
     * @param {int} page Numéro de page
     */
    async getSearchResults(searchQuery, type, page) {
        return await this._computeFetch("https://api.jikan.moe/v3/search/" + type + "?q=" + searchQuery + "&page=" + page + "&rated=r17"); // "&rated=r17" sert a filtrer les résultats
    }

    /**
     * Retourne un manga via son id
     * @param {int} mangaId Id du manga en question
     */
    async getMangaById(mangaId) {
        return await this._computeFetch("https://api.jikan.moe/v3/manga/" + mangaId);
    }

    /**
     * @private
     * Récupère un index aléatoire
     */
    _getRandomIndex() {
        return Math.floor(Math.random() * 10060);
    }

    /**
     * Execution du fetch
     * @param {string} url Url pour le fetch
     */
    async _computeFetch(url) {
        return await fetch(url)
        .then((response) => {
            // Gestion des erreures (Va dans le 'catch' si une erreure est 'throw')
            if (!response.ok) {
                throw {
                    ErrorNo: response.status // Récupération du numéro de l'erreure HTTP
                };
            }

            return response.json();
        })
        .then((data) => {
            return data;
        })
        .catch((error) => {
            return this._errorHandler(error.ErrorNo);
        });
    }

    /**
     * Prise en charge la gestion des erreures
     * @param {int} errorNo Numéro de l'erreure
     */
    _errorHandler(errorNo) {
        switch (errorNo) {
            case 404:
                return {msg: "Page non trouvée", errorNo};

            case 500:
                return {msg: "Erreur du côté serveur", errorNo};
                
            default:
                return {msg: "Erreur lors de l'execution d'une fonction. (Je n'arrive pas encore a récupéré le nom de la fonction parent lorsque ca vient d'une Promise)", errorNo};
        }
    }

    /**
     * Ecrase la fonction 'toString()' par défauit 
     */
    toString() {
        return "Ceci est la classe permettant d'utiliser avec facilité l'API rest 'Jikan.js'.";
    }
}