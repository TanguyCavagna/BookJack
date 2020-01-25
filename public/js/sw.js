const CACHE_NAME = 'book-jack';
const CACHE_FILES = [
    '/BookJack/',
    '/BookJack/public/index.php',
    '/BookJack/public/js/app.js',
    '/BookJack/manifest.webmanifest'
];

// Initialise le cache
self.addEventListener('install', e => {
    console.log("[sw.js] Install event.");
    e.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(CACHE_FILES))
            .then(self.skipWaiting())
            .catch(err => console.error("[sw.js] Error trying to pre-fetch cache files:", err))
    );
});

// Active le `service worker`
self.addEventListener('activate', e => {
    self.clients.claim();
});

// Handle le clic sur les notifications
self.addEventListener('notificationclick', function (e) {
    var notification = e.notification;
    var action = e.action;

    if (action === 'close') { // clic sur le bouton "close"
        console.log('Closed');
        notification.close();
    } else if (action === 'explore') { // clic sur le bouton "explore"
        console.log('Explored');
        notification.close();
    } else { // clic n'importe où sur la notification
        notification.close();
    }
});
