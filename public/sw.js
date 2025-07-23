const CACHE_NAME = 'pebs-v2';
const urlsToCache = [
  '/',
  '/index',
  '/login',
  '/register',
  '/images/pebs-logo.png',
  '/offline.html',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css',
  'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js',
  'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css'
];

// Routes that should always fetch from network (authentication-related)
const networkFirstRoutes = [
  '/login',
  '/logout',
  '/register',
  '/admin',
  '/superadmin',
  '/shared',
  '/dashboard'
];

// Check if URL should use network-first strategy
function shouldUseNetworkFirst(url) {
  return networkFirstRoutes.some(route => url.includes(route)) || 
         url.includes('csrf') || 
         url.includes('_token') ||
         url.includes('login') ||
         url.includes('logout');
}

// Install Service Worker
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

// Fetch event
self.addEventListener('fetch', (event) => {
  const url = event.request.url;
  const method = event.request.method;
  
  // Skip non-GET requests and admin/auth routes
  if (method !== 'GET' || shouldUseNetworkFirst(url)) {
    // For POST requests and authentication routes, always go to network
    event.respondWith(
      fetch(event.request).catch(() => {
        // If network fails and it's a document request, show offline page
        if (event.request.destination === 'document') {
          return caches.match('/offline.html');
        }
        // For other requests, return a failed response
        return new Response('Network error', { status: 503 });
      })
    );
    return;
  }
  
  // For regular GET requests, use cache-first strategy
  event.respondWith(
    caches.match(event.request)
      .then((response) => {
        // Return cached version if available
        if (response) {
          return response;
        }
        
        // Fetch from network and cache the response
        return fetch(event.request)
          .then((networkResponse) => {
            // Check if response is valid
            if (!networkResponse || networkResponse.status !== 200 || networkResponse.type !== 'basic') {
              return networkResponse;
            }
            
            // Clone the response for caching
            const responseToCache = networkResponse.clone();
            
            // Add to cache for future use
            caches.open(CACHE_NAME)
              .then((cache) => {
                cache.put(event.request, responseToCache);
              });
            
            return networkResponse;
          })
          .catch(() => {
            // If both cache and network fail, show offline page for documents
            if (event.request.destination === 'document') {
              return caches.match('/offline.html');
            }
          });
      })
  );
});

// Activate Service Worker
self.addEventListener('activate', (event) => {
  const cacheWhitelist = [CACHE_NAME];
  
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

// Background sync for form submissions when online
self.addEventListener('sync', (event) => {
  if (event.tag === 'background-sync') {
    console.log('Background sync triggered');
    // Handle background sync for form submissions
  }
});

// Push notifications (if needed later)
self.addEventListener('push', (event) => {
  if (event.data) {
    const data = event.data.json();
    const options = {
      body: data.body,
      icon: '/images/pebs-logo.png',
      badge: '/images/pebs-logo.png',
      vibrate: [100, 50, 100],
      data: {
        dateOfArrival: Date.now(),
        primaryKey: data.primaryKey
      },
      actions: [
        {
          action: 'explore',
          title: 'View Details',
          icon: '/images/pebs-logo.png'
        },
        {
          action: 'close',
          title: 'Close',
          icon: '/images/pebs-logo.png'
        }
      ]
    };
    
    event.waitUntil(
      self.registration.showNotification(data.title, options)
    );
  }
});

// Handle notification clicks
self.addEventListener('notificationclick', (event) => {
  event.notification.close();
  
  if (event.action === 'explore') {
    event.waitUntil(
      clients.openWindow('/')
    );
  }
});