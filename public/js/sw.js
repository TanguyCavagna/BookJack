const CACHE_NAME = 'book-jack';
const CACHE_FILES = [
    '/BookJack/',
    '/BookJack/public/index.php',
    '/BookJack/public/js/app.js',
    '/BookJack/manifest.webmanifest'
];

// Initialize the cache
self.addEventListener('install', e => {
    console.log("[sw.js] Install event.");
    e.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(CACHE_FILES))
            .then(self.skipWaiting())
            .catch(err => console.error("[sw.js] Error trying to pre-fetch cache files:", err))
    );
});

// Activate the service workers
self.addEventListener('activate', e => {
    self.clients.claim();
});

// Handle the notification click
self.addEventListener('notificationclick', function (e) {
    var notification = e.notification;
    var action = e.action;

    if (action === 'close') { // click on the 'close' button
        console.log('Closed');
        notification.close();
    } else if (action === 'explore') { // click on the 'explore' button
        console.log('Explored');
        notification.close();
    } else { // click anywhere on the notification
        notification.close();
    }
});
