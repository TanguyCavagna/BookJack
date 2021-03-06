$(document).ready(() => {
    $('#login').click(login);
    $('.errors').hide();
});

/**
 * Login avec AJAX
 * @param {*} event 
 */
function login(event) {
    if (event) {
        event.preventDefault();
    }

    // intialisation
    let username = $("#username").val();
    let password = $("#password").val();

    // processing
    if (username.length == 0) {
        $("#username").css("border-color", "red");
        $("#username").focus();
        return;
    } else {
        $("#username").css("border-color", "");
    }

    if (password.length == 0) {
        $("#password").css("border-color", "red");
        $("#password").focus();
        return;
    } else {
        $("#password").css("border-color", "");
    }

    get_data("../App/Api/login.php", (data) => {
        window.location = "./index.php";
    }, { "username": username, "password": password }, false);
}