$(document).ready(function() {
    $('#login').click(login);
});

/**
 * Login with ajax
 * @param {*} event 
 */
function login(event) {
    if (event) {
        event.preventDefault();
    }

    // intialisation
    var password = $("password").val();
}