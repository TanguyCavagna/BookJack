
$(document).ready(() => {
    registerSW();

    Notification.requestPermission((status) => { });

    $('#login').click(login);
    $('.errors').hide();

    $('#register').click(register);

    $('#test').click(() => {
        showNotification();
    });

    $('.alert').delay(2000).fadeOut(3000);

    console.log(window.location.pathname);
});

/**
 * Register the service worker for the app
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
 * Login with ajax
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

    get_data("../../App/Api/register.php", (data) => {
        window.location = "../public/login.php";
    }, {}, false);
}