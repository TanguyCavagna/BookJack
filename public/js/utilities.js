/**
 * @copyright dario.gng@eduge.ch
 * Effectue un appel ajax et exécute une fonction en cas de succès
 *
 * La réponse JSON doit impérativement contenir les paramêtres :
 *      -ResponseCode -> code indiquant le status de la reponse
 *      -Data         -> Valeurs renvoyer en tant que reponse AJAX
 *
 *
 * @param string url        Le chemin vers le fichier qui va récupérer nos données
 * @param string callback   Le nom de la fonction à exécuter après avoir reçu les données. Il ne faut pas mettre de parenthèses
 * @param object params     Object qui contient tout les paramètres à envoyer
 * @param boolean async		Pour activer / désactiver l'asynchrone d'un appel ajax
 */
function get_data(url, callback, params = {}, async) {
    // Copier l'objet params dans une variable locale
    // qui sera simplement utilisées pour l'appel Ajax
    var dp = params;
    // On utilise le paramètre de la fonction qui est stocké sur le stack
    // pour créer un tableau qui contient les paramètres additionnels qui se
    // trouvent après params.
    // Si on stocke ces paramètres dans un tableau créé dans cette function,
    // il sera détruit après l'appel Ajax et on aura plus rien lorsqu'on sera
    // rappelé de manière asynchrone.
    params = Array();
    for (var i = 4; i < arguments.length; i++) {
        params.push(arguments[i]);
    }
    $.ajax({
        method: 'POST',
        url: url,
        data: dp,
        dataType: 'json',
        async: async,
        success: function (data) {
            var msg = '';
           // console.log(data);

            if (data != null) {
            // console.log(data.ReturnCode);
                switch (data.ReturnCode) {
                    case 0 : // tout bon
                        // On récupère par params, notre tableau des arguments.
                        params.unshift(data.Data);
                        callback.apply(this, params);
                        break;
                    case 1: // Donnée récupéré vide
                        console.log(data.Error);
                        break;
                    default:
                        msg = data.Message;
                        break;
                }
            }
        },
        error: function (jqXHR) {
            if (jqXHR.responseText != "")
                console.log(jqXHR);
            // Votre gestion de l'erreur
        }
    });
}