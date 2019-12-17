$(document).ready(() => {
    registerSW();

    Notification.requestPermission((status) => { });

    $('#test').click(() => {
        showNotification();
    });

    $('.alert').delay(2000).fadeOut(3000);
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