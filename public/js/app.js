$(document).ready(() => {
    registerSW();

    Notification.requestPermission((status) => {});

    $('#login').click(login);

    $('#test').click(() => {
        showNotification();
    });
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
    var username = $("username").val();
    var password = $("password").val();

    // processing
    if (username.length == 0) {
        $("#username").css("border-color", "red");
        return;
    } else {
        $("#username").css("border-color", "");
    }

    if (password.length == 0) {
        $("#password").css("border-color", "red");
        return;
    } else {
        $("#password").css("border-color", "");
    }

    get_data("../../App/Api/login.php", (data) => {
        window.location = "../index.php";
    }, { "username": username, "password": password }, false);
}
