/**
 * Envoie une nouvelle notification
 */
function showNotification() {
    if (Notification.permission == 'granted') {
        navigator.serviceWorker.getRegistration('./js/sw.js').then((reg) => {
            var options = {
                body: 'Here is a notification body!',
                icon: './img/icon-192x192.png',
                vibrate: [100, 50, 100],
                data: {
                    dateOfArrival: Date.now(),
                    primaryKey: 1
                },
                actions: [
                    {
                        action: 'explore', title: 'Explore this new world',
                        icon: './img/icon-192x192.png'
                    },
                    {
                        action: 'close', title: 'Close notification',
                        icon: './img/icon-192x192.png'
                    },
                ]
            };

            reg.showNotification('Hello world!', options);
        });
    }
}