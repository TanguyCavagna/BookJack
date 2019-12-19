
$(document).ready(() => {
    $('#register').click(register);
});

/**
 * Register with ajax
 * @param {*} event 
 */
function register(event) {
    if (event) {
        event.preventDefault();
    }

    // intialisation
    let username = $("#username").val();
    let mail = $("#mail").val();
    let password = $("#password").val();
    let verifyPassword = $("#verify-password").val();

    // processing
    if (username.length == 0) {
        $("#username").css("border-color", "red");
        $("#username").focus();
        return;
    } else {
        $("#username").css("border-color", "");
    }

    if (mail.length == 0) {
        $("#mail").css("border-color", "red");
        $("#mail").focus();
        return;
    } else {
        $("#mail").css("border-color", "");
    }

    if (password.length == 0) {
        $("#password").css("border-color", "red");
        $("#password").focus();
        return;
    } else {
        $("#password").css("border-color", "");
    }

    if (verifyPassword.length == 0) {
        $("#verify-password").css("border-color", "red");
        $("#verify-password").focus();
        return;
    } else {
        $("#verify-password").css("border-color", "");
    }

    get_data("../App/Api/register.php", (data) => {
        window.location = "./login.php";
    }, {"username":username, "mail":mail, "password":password, "verifyPassword":verifyPassword}, false);
}