const CACHE_NAME = "pwa-cache-v1";

const CORE_ASSETS = [
    "/",
    "/index.html",
    "/about.html",
    "/benefits.html",
    "/home.html",
    "/signin.css",
    "/profile.css",
    "/signin.js",
    "/profile.js",
    "/header.jpg",
    "/icon.jpg",
    "/slts.png",
    "/alert.png",
    "/background.svg",
    "/worldmap.svg",
    "/emergency_sound.mp3",
    "/purple.svg",
];

self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(CORE_ASSETS);
        })
    );
});

self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.match(event.request).then((cachedResponse) => {
            return (
                cachedResponse ||
                fetch(event.request).then((networkResponse) => {
                    const url = new URL(event.request.url);
                    if (
                        [".html", ".css", ".js", ".jpg", ".png", ".svg", ".mp3"].some((ext) =>
                            url.pathname.endsWith(ext)
                        )
                    ) {
                        return caches.open(CACHE_NAME).then((cache) => {
                            cache.put(event.request, networkResponse.clone());
                            return networkResponse;
                        });
                    }
                    return networkResponse;
                })
            );
        })
    );
});

self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
});
