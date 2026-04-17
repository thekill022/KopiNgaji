self.addEventListener('push', function(event) {
    const data = event.data.json();
    const title = data.title || 'KopiNgaji';
    const options = {
        body: data.body || '',
        icon: data.icon || '/favicon.ico',
        badge: data.badge || '/favicon.ico',
        data: data.data || {},
        actions: data.actions || [],
    };
    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    const url = event.notification.data?.url || '/';
    event.waitUntil(clients.openWindow(url));
});
