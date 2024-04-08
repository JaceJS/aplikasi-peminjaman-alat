self.addEventListener('install', event => {
  event.waitUntil(
    caches.open('cache-penyimpanan').then(cache => {
      return cache.addAll([
        'index.php',
        'index.css',
        'bootstrap/bootstrap-v5.min.css',
        'images/logo.svg'
      ]).catch(error => {
        console.error('Error adding resources to cache:', error);
      });
    })
  );
});
